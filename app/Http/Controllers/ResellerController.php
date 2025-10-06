<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;

use App\Models\Reseller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = 1;

        $resellers = Reseller::with("address")
            ->with("contacts")
            ->where("user_id", $userId)
            ->get();
        //
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
                "user_id" => 1,
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
            $reseller->contacts()->create($request->only(["phone", "email"]));
        });

        return redirect()
            ->route("resellers.index")
            ->with("success", "Reseller created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Reseller $reseller)
    {
        $reseller->load(["address", "contacts"]);
        return view("resellers.show", compact("reseller"));
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
                [],
                [
                    "street" => $validated["street"],
                    "number" => $validated["number"],
                    "city" => $validated["city"],
                    "state" => $validated["state"],
                    "zip_code" => $validated["zip_code"],
                ],
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
            ->with("success", "Reseller updated successfully!");
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
            $reseller->delete();
        });

        return redirect()
            ->route("resellers.index")
            ->with("success", "Reseller deleted successfully!");
    }

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
