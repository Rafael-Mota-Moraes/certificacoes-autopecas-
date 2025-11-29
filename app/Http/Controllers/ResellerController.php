<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ChecksCertificateEligibility;
use App\Models\Certificate;
use App\Models\Reseller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;

class ResellerController extends Controller
{
    use ChecksCertificateEligibility;


    public function show(Request $request, Reseller $reseller)
    {
        $reseller->load('certificate');

        $allReviewsQuery = $reseller->reviews();
        $averageRating = $allReviewsQuery->avg('rating') ?? 0;

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

        $eligibility = $this->checkEligibility($reseller);
        $reviewsQuery = $reseller->reviews()->with('user', 'comments');

        $currentRating = $request->input('rating');
        if ($currentRating && in_array($currentRating, [1, 2, 3, 4, 5])) {
            $reviewsQuery->where('rating', $currentRating);
        }

        $reviews = $reviewsQuery->latest()->paginate(18);

        $hasActiveCertificate = Certificate::find($reseller->certificate?->id)?->where('status', 'paid')->exists();

        return view('resellers.show', [
            'reseller' => $reseller,
            'reviews' => $reviews,
            'hasActiveCertificate' => $hasActiveCertificate,
            'averageRating' => $averageRating,
            'totalReviews' => $eligibility['totalReviews'],
            'positivePercentage' => round($eligibility['positivePercentage'] * 100),
            'criteriaReviews' => self::MINIMUM_REVIEWS_REQUIRED,
            'criteriaPercentage' => self::REQUIRED_HIGH_RATING_PERCENTAGE * 100,
            'meetsReviews' => $eligibility['meetsReviews'],
            'meetsPercentage' => $eligibility['meetsPercentage'],
            'starCounts' => $starCounts,
            'currentRating' => $currentRating,
        ]);
    }

    public function index()
    {
        $resellers = Reseller::withTrashed()->where("user_id", auth()->id())
            ->with("address", "contacts", "certificate")
            ->withExists(['certificate as has_active_certificate' => function ($query) {
                $query->where('status', 'pago');
            }])
            ->orderBy('has_active_certificate', 'desc')
            ->orderBy('name', 'asc')->get();

        return view("resellers.index", compact("resellers"));
    }


    public function create()
    {
        return view("resellers.create");
    }


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

        $coordinates = $this->getCoordinatesFromAddress(
            $validated["street"],
            $validated["number"],
            $validated["city"],
            $validated["state"],
            $validated["zip_code"]
        );


        DB::transaction(function () use ($validated, $request, $coordinates) {
            $photoPath = null;
            if ($request->hasFile("photo")) {
                $photoPath = $request
                    ->file("photo")
                    ->store("reseller_photos", "public");
            }

            $reseller = Reseller::create([
                "user_id" => auth()->id(),
                "name" => $validated["name"],
                "cnpj" => $validated["cnpj"],
                "photo" => $photoPath,
            ]);

            $reseller
                ->address()
                ->create(array_merge(
                    $request->only([
                        "street",
                        "number",
                        "city",
                        "state",
                        "zip_code",
                    ]),
                    [
                        'latitude' => $coordinates['lat'],
                        'longitude' => $coordinates['lon'],
                    ]
                ));

            foreach ($validated["contacts"] as $contactData) {
                $reseller->contacts()->create($contactData);
            }
        });

        return redirect()
            ->route("resellers.index")
            ->with("success", "Revendedora criada com sucesso!");
    }



    public function edit(Reseller $reseller)
    {
        $reseller->load(["address", "contacts"]);
        return view("resellers.edit", compact("reseller"));
    }


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

        $coordinates = $this->getCoordinatesFromAddress(
            $validated["street"],
            $validated["number"],
            $validated["city"],
            $validated["state"],
            $validated["zip_code"]
        );
        DB::transaction(function () use ($validated, $reseller, $request, $coordinates) {
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
                ['reseller_id' => $reseller->id],
                [
                    "street" => $validated["street"],
                    "number" => $validated["number"],
                    "city" => $validated["city"],
                    "state" => $validated["state"],
                    "zip_code" => $validated["zip_code"],
                    'latitude' => $coordinates['lat'],
                    'longitude' => $coordinates['lon'],
                ]
            );

            $reseller->contacts()->delete();
            foreach ($validated["contacts"] as $contactData) {
                $reseller->contacts()->create([
                    "phone" => $contactData["phone"],
                    "email" => $contactData["email"],
                ]);
            }
        });

        return redirect()
            ->route("resellers.index")
            ->with("success", "Revendedora atualizada com sucesso!");
    }

    public function updatePhoto(Request $request, Reseller $reseller): RedirectResponse
    {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $currentPhotoPath = $reseller->getAttributes()['photo'] ?? null;

        if ($request->hasFile("photo")) {
            if ($currentPhotoPath) {
                Storage::disk("public")->delete($currentPhotoPath);
            }

            $newPhotoPath = $request
                ->file("photo")
                ->store("reseller_photos", "public");

            $reseller->update(['photo' => $newPhotoPath]);
        }

        return redirect()
            ->route("resellers.index")
            ->with("success", "Foto da revendedora atualizada com sucesso!");
    }


    private function getCoordinatesFromAddress(string $street, string $number, string $city, string $state, string $zip_code): array
    {
        $addressString = "{$number} {$street}, {$city}, {$state}, {$zip_code}";
        $apiUrl = "https://nominatim.openstreetmap.org/search";

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'certificar/1.0 (noreply@certificar.com)'
            ])->get($apiUrl, [
                'q' => $addressString,
                'format' => 'json',
                'limit' => 1
            ]);

            if ($response->successful() && !empty($response->json())) {
                $data = $response->json()[0];
                return [
                    'lat' => $data['lat'],
                    'lon' => $data['lon'],
                ];
            }

            return ['lat' => null, 'lon' => null];
        } catch (\Exception $e) {
            return ['lat' => null, 'lon' => null];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reseller $reseller)
    {
        $reseller->delete();

        return redirect()
            ->route("resellers.index")
            ->with("success", "Revendedora desativada com sucesso!");
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $reseller = Reseller::withTrashed()->find($id);
        if ($reseller) {
            $reseller->restore();
        }

        return redirect()
            ->route("resellers.index")
            ->with("success", "Revendedora reativada com sucesso!");
    }
}
