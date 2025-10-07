<?php

namespace App\Http\Controllers;

use App\Models\UserReport;
use Illuminate\Http\Request;

class UserReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect("user_report.report");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("user_report.report");
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|max:255',
            'report' => 'required',
        ]);

        $report = new UserReport;
        $report->user_email = $validatedData['email'];
        $report->bug_message = $validatedData['report'];
        $report->save();
        $response = redirect()->back()->with('success', 'Nossa equipe avaliará sua contribuição, obrigado!');
        return $response;
    }
    /**
     * Display the specified resource.
     */
    public function show(UserReport $userReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserReport $userReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserReport $userReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserReport $userReport)
    {
        //
    }
}
