<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
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
        // FIX: Changed 'contact' to 'contacts' to match the HasMany relationship
        $resellers = Reseller::with(['address', 'contact'])->latest()->paginate(10);
        return view('resellers.index', compact('resellers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resellers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:resellers,cnpj',
            // FIX: Changed 'photo_path' to 'photo' to match the form input name
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // FIX: Changed from 'address.*.street' to flat keys to match the form
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',

            // FIX: Changed 'contact' to 'contacts' to match the form and relationship
            'contact' => 'required|array|min:1',
            'contact.*.phone' => 'required|string|max:20',
            // FIX: Corrected table name from 'contact' to 'contact' for the unique rule
            'contact.*.email' => 'required|email|unique:contact,email',
        ]);

        // Use a database transaction to ensure data integrity
        DB::transaction(function () use ($validated, $request) {
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('reseller_photos', 'public');
            }

            // Create the reseller
            $reseller = Reseller::create([
                'name' => $validated['name'],
                'cnpj' => $validated['cnpj'],
                'photo_path' => $photoPath,
            ]);

            // Create the associated address using the corrected flat keys
            $reseller->address()->create([
                'street' => $validated['street'],
                'number' => $validated['number'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
            ]);

            // Create the associated contacts using the corrected 'contacts' array
            foreach ($validated['contacts'] as $contactData) {
                $reseller->contacts()->create([
                    'phone' => $contactData['phone'],
                    'email' => $contactData['email'],
                ]);
            }
        });

        echo 'saved with success';
        return redirect()->route('resellers.index')->with('success', 'Reseller created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Reseller $reseller)
    {
        // FIX: Changed 'contact' to 'contacts'
        $reseller->load(['address', 'contact']);
        return view('resellers.show', compact('reseller'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reseller $reseller)
    {
        // FIX: Changed 'contact' to 'contact'
        $reseller->load(['address', 'contact']);
        return view('resellers.edit', compact('reseller'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reseller $reseller)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:resellers,cnpj,' . $reseller->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'contact' => 'required|array|min:1',
            'contact.*.phone' => 'required|string|max:20',
            'contact.*.email' => 'required|email',
        ]);

        DB::transaction(function () use ($validated, $reseller, $request) {
            $photoPath = $reseller->photo_path;
            if ($request->hasFile('photo')) {
                // Delete old photo if it exists
                if ($photoPath) {
                    Storage::disk('public')->delete($photoPath);
                }
                $photoPath = $request->file('photo')->store('reseller_photos', 'public');
            }

            $reseller->update([
                'name' => $validated['name'],
                'cnpj' => $validated['cnpj'],
                'photo_path' => $photoPath,
            ]);

            $reseller->address()->updateOrCreate([], [
                'street' => $validated['street'],
                'number' => $validated['number'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
            ]);

            $reseller->contacts()->delete();
            foreach ($validated['contacts'] as $contactData) {
                $reseller->contacts()->create([
                    'phone' => $contactData['phone'],
                    'email' => $contactData['email'],
                ]);
            }
        });

        return redirect()->route('resellers.index')->with('success', 'Reseller updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reseller $reseller)
    {
        DB::transaction(function () use ($reseller) {
            if ($reseller->photo_path) {
                Storage::disk('public')->delete($reseller->photo_path);
            }
            $reseller->address()->delete();
            $reseller->contacts()->delete();
            $reseller->delete();
        });

        return redirect()->route('resellers.index')->with('success', 'Reseller deleted successfully!');
    }
}
