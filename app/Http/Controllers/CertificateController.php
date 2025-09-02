<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): Integer
    {
        $certificates = 0;
        return response()->json($certificates);
    }

    /**
        * Creates and stores a new certificate in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\JsonResponse
        */
    public function create(Request $request): JsonResponse
    {
        // Validate the incoming request data based on the Certificate model
        $validatedData = $request->validate([
            'status' => ['required', 'string', 'max:255'],
            'validate' => ['required', 'date'],
            'city' => ['required', 'string', 'max:255'],
            'signature' => ['required', 'string'],
            'text' => ['required', 'string'],
        ]);

        $certificate = Certificate::create($validatedData);

        // Return the newly created certificate with a 201 "Created" status code
        return response()->json($certificate, 201);
    }

    /**
     * Store a newly created certificate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
            'validate' => 'required|email|unique:contact,email',
            'created_at' => 'required|string|unique:resellers,cnpj',
            'city' => 'required|string|max:255',
            'signature' => 'required|string|max:255',
            'text' => 'required|string|max:255',
        ]);

        // Use a database transaction to ensure data integrity
        DB::transaction(function () use ($validated) {
            // Create the reseller
            $reseller = Certificate::create([
                'status' => $validated['status'],
                'validate' => $validated['validate'],
                'created_at' => $validated['created_at'],
                'city' => $validated['city'],
                'signature' => $validated['signature'],
                'text' => $validated['text'],
            ]);
        });

        return redirect()->route('home')->with('success', 'Reseller created successfully!');
    }

    /**
     * Display the specified certificate.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Certificate $certificate): JsonResponse
    {
        // Route Model Binding automatically finds the certificate.
        // Return it as a JSON response to be consistent with an API.
        return response()->json($certificate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\View\View
     */
    public function edit(Certificate $certificate): View
    {
        // This method should return the view for editing an existing certificate,
        // passing the certificate data to the view.
        return view('certificates.edit', ['certificate' => $certificate]);
    }


    /**
     * Update the specified certificate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Certificate $certificate): JsonResponse
    {
        // Validate the incoming request data. 'sometimes' allows for partial updates.
        $validatedData = $request->validate([
            'status' => ['sometimes', 'required', 'string', 'max:255'],
            'validate' => ['sometimes', 'required', 'date'],
            'city' => ['sometimes', 'required', 'string', 'max:255'],
            'signature' => ['sometimes', 'required', 'string'],
            'text' => ['sometimes', 'required', 'string'],
        ]);

        // Update the certificate's attributes
        $certificate->update($validatedData);

        // Return the updated certificate
        return response()->json($certificate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Certificate $certificate): JsonResponse
    {
        // Delete the certificate
        $certificate->delete();

        // Return a 204 "No Content" response to indicate successful deletion
        return response()->json(null, 204);
    }
}
