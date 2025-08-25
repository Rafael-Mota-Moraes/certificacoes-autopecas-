<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
                    'email' => 'required|email|unique:contact,email',
                    'cnpj' => 'required|string|unique:resellers,cnpj',
                    'street' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'state' => 'required|string|max:255',
                    'zip_code' => 'required|string|max:20',
                    'phone' => 'required|string|max:20',
                    'whatsapp' => 'nullable|string|max:20',
                ]);

                // Use a database transaction to ensure data integrity
                DB::transaction(function () use ($validated) {
                    // Create the reseller
                    $reseller = Reseller::create([
                        'name' => $validated['name'],
                        'cnpj' => $validated['cnpj'],
                    ]);

                    // Create the associated address
                    $reseller->address()->create([
                        'street' => $validated['street'],
                        'city' => $validated['city'],
                        'state' => $validated['state'],
                        'zip_code' => $validated['zip_code'],
                    ]);

                    // Create the associated contact
                    $reseller->contact()->create([
                        'phone' => $validated['phone'],
                        'email' => $validated['email'],
                    ]);
                });

                return redirect()->route('resellers.index')->with('success', 'Reseller created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reseller $reseller)
    {
        $reseller->load(['address', 'contact']);
                return view('resellers.show', compact('reseller'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reseller $reseller)
    {
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
                    // Ignore the current reseller's email when checking for uniqueness
                    'cnpj' => 'required|string|unique:resellers,cnpj,' . $reseller->id,
                    'email' => 'required|email|unique:contact,email,' . $reseller->id,
                    'street' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'state' => 'required|string|max:255',
                    'zip_code' => 'required|string|max:20',
                    'phone' => 'required|string|max:20',
                ]);

                DB::transaction(function () use ($validated, $reseller) {
                    // Update reseller details
                    $reseller->update([
                        'name' => $validated['name'],
                        'cnpj' => $validated['cnpj'],
                    ]);

                    // Update address details (use updateOrCreate to handle cases where it might not exist)
                    $reseller->address()->updateOrCreate([], [
                        'street' => $validated['street'],
                        'city' => $validated['city'],
                        'state' => $validated['state'],
                        'zip_code' => $validated['zip_code'],
                    ]);

                    // Update contact details
                    $reseller->contact()->updateOrCreate([], [
                        'phone' => $validated['phone'],
                        'email' => $validated['email'],
                    ]);
                });

                return redirect()->route('resellers.index')->with('success', 'Reseller updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reseller $reseller)
    {
        $reseller->delete();
        return redirect()->route('resellers.index')->with('success', 'Reseller deleted successfully!');
    }
}
