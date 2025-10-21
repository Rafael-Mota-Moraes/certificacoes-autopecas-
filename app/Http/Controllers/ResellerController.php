<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ChecksCertificateEligibility;
use App\Models\Reseller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// 1. Importar o Trait

class ResellerController extends Controller
{
    use ChecksCertificateEligibility;

    // 2. Usar o Trait

    /**
     * Exibe a página de detalhes e avaliações da revendedora.
     */
    public function show(Request $request, Reseller $reseller)
    {
        $reseller->load('certificate');

        // --- Query base e cálculos de média/total ---
        $allReviewsQuery = $reseller->reviews();
        $averageRating = $allReviewsQuery->avg('rating') ?? 0;

        // Contagem para cada estrela
        $ratingCounts = (clone $allReviewsQuery)
            ->select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->all();

        $starCounts = [
            '5' => $ratingCounts[5] ?? 0,
            '4' => $ratingCounts[4] ?? 0,
            '3' => $ratingCounts[3] ?? 0,
            '2' => $ratingCounts[2] ?? 0,
            '1' => $ratingCounts[1] ?? 0,
        ];

        // --- LÓGICA DE CRITÉRIOS (agora usa o Trait) ---
        $eligibility = $this->checkEligibility($reseller);
        // ----------------------------------------------

        // --- Filtragem e Paginação ---
        $reviewsQuery = $reseller->reviews()->with('user', 'comments');

        $currentRating = $request->input('rating');
        if ($currentRating && in_array($currentRating, [1, 2, 3, 4, 5])) {
            $reviewsQuery->where('rating', $currentRating);
        }

        $reviews = $reviewsQuery->latest()->paginate(8);

        // --- Envia tudo para a View ---
        return view('resellers.show', [
            'reseller' => $reseller,
            'reviews' => $reviews,
            'averageRating' => $averageRating,

            // Variáveis vindas do Trait
            'totalReviews' => $eligibility['totalReviews'],
            'positivePercentage' => round($eligibility['positivePercentage'] * 100),

            // Constantes do Trait
            'criteriaReviews' => self::MINIMUM_REVIEWS_REQUIRED,
            'criteriaPercentage' => self::REQUIRED_HIGH_RATING_PERCENTAGE * 100, // Envia 80

            // Resultados Booleanos do Trait
            'meetsReviews' => $eligibility['meetsReviews'],
            'meetsPercentage' => $eligibility['meetsPercentage'],

            // Outras vars
            'starCounts' => $starCounts,
            'currentRating' => $currentRating,
        ]);
    }

    /**
     * Exibe a lista de revendedoras do usuário (Minhas Revendedoras).
     */
    public function index()
    {
        // 3. Ordenar pelo certificado
        $resellers = Reseller::where("user_id", auth()->id())
            ->with("address", "contacts", "certificate") // Carrega o certificado
            // Cria uma coluna virtual 'has_active_certificate' (true/false)
            ->withExists(['certificate as has_active_certificate' => function ($query) {
                $query->where('status', 'pago');
            }])
            // Ordena por essa coluna, colocando os 'true' (certificados) primeiro
            ->orderBy('has_active_certificate', 'desc')
            ->orderBy('name', 'asc') // Ordena alfabeticamente como segundo critério
            ->paginate(9); // Pagina os resultados

        return view("resellers.index", compact("resellers"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("resellers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "cnpj" => "required|string|unique:resellers,cnpj",
            "photo" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "street" => "required|string|max:255",
            "number" => "required|string|max:255",
            "city" => "required|string|max:255",
            "state" => "required|string|max:255",
            "zip_code" => "required|string|max:20",
            "contacts" => "required|array|min:1",
            "contacts.*.phone" => "required|string|max:20",
            "contacts.*.email" => "required|email|unique:contacts,email",
        ]);

        DB::transaction(function () use ($validated, $request) {
            $photoPath = null;
            if ($request->hasFile("photo")) {
                $photoPath = $request
                    ->file("photo")
                    ->store("reseller_photos", "public");
            }

            $reseller = Reseller::create([
                "user_id" => auth()->id(), // 4. Corrigido
                "name" => $validated["name"],
                "cnpj" => $validated["cnpj"],
                "photo" => $photoPath,
            ]);

            $reseller
                ->address()
                ->create(
                    $request->only([
                        "street",
                        "number",
                        "city",
                        "state",
                        "zip_code",
                    ]),
                );

            // 5. Corrigido para salvar múltiplos contatos
            foreach ($validated["contacts"] as $contactData) {
                $reseller->contacts()->create($contactData);
            }
        });

        return redirect()
            ->route("resellers.index")
            ->with("success", "Revendedora criada com sucesso!");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reseller $reseller)
    {
        $reseller->load(["address", "contacts"]);
        return view("resellers.edit", compact("reseller"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reseller $reseller)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "cnpj" => "required|string|unique:resellers,cnpj," . $reseller->id,
            "photo" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "street" => "required|string|max:255",
            "number" => "required|string|max:255",
            "city" => "required|string|max:255",
            "state" => "required|string|max:255",
            "zip_code" => "required|string|max:20",
            "contacts" => "required|array|min:1",
            "contacts.*.phone" => "required|string|max:20",
            "contacts.*.email" => "required|email",
        ]);

        DB::transaction(function () use ($validated, $reseller, $request) {
            $photoPath = $reseller->photo;
            if ($request->hasFile("photo")) {
                if ($photoPath) {
                    Storage::disk("public")->delete($photoPath);
                }
                $photoPath = $request
                    ->file("photo")
                    ->store("reseller_photos", "public");
            }

            $reseller->update([
                "name" => $validated["name"],
                "cnpj" => $validated["cnpj"],
                "photo" => $photoPath,
            ]);

            $reseller->address()->updateOrCreate(
                ['reseller_id' => $reseller->id], // Condição para encontrar
                [ // Valores para atualizar ou criar
                    "street" => $validated["street"],
                    "number" => $validated["number"],
                    "city" => $validated["city"],
                    "state" => $validated["state"],
                    "zip_code" => $validated["zip_code"],
                ],
            );

            $reseller->contacts()->delete(); // Apaga os antigos
            foreach ($validated["contacts"] as $contactData) {
                $reseller->contacts()->create([ // Cria os novos
                    "phone" => $contactData["phone"],
                    "email" => $contactData["email"],
                ]);
            }
        });

        return redirect()
            ->route("resellers.index")
            ->with("success", "Revendedora atualizada com sucesso!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reseller $reseller)
    {
        DB::transaction(function () use ($reseller) {
            if ($reseller->photo) {
                Storage::disk("public")->delete($reseller->photo);
            }
            $reseller->address()->delete();
            $reseller->contacts()->delete();
            // Outras relações (reviews, certificate) serão deletadas pelo 'onDelete('cascade')'
            $reseller->delete();
        });

        return redirect()
            ->route("resellers.index")
            ->with("success", "Revendedora desativada com sucesso!");
    }

    /**
     * Armazena uma nova avaliação (rating) para uma revendedora.
     */
    public function storeRating(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "reseller_id" => "required|exists:resellers,id",
            "rating" => "required|integer|min:1|max:5",
            "comment_ids" => "nullable|array",
            "comment_ids.*" => "integer|exists:comments,id",
        ]);

        $review = Review::create([
            "reseller_id" => $validated["reseller_id"],
            "user_id" => auth()->id(),
            "rating" => $validated["rating"],
        ]);

        if (!empty($validated["comment_ids"])) {
            $review->comments()->attach($validated["comment_ids"]);
        }

        return redirect()
            ->back()
            ->with("success", "Avaliação enviada com sucesso!");
    }
}