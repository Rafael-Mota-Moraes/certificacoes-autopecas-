<?php

namespace App\Http\Controllers;

use App\Models\UserReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'report' => 'required|string|min:10|max:2000',
        ];

        if (Auth::guest()) {
            $rules['email'] = 'required|email|max:255';
        }

        $validatedData = $request->validate($rules);

        $report = new UserReport;
        $report->bug_message = $validatedData['report'];

        $report->user_email = Auth::check() ? Auth::user()->email : $validatedData['email'];

        $report->save();

        return redirect()->back()->with('success', 'Nossa equipe avaliará sua contribuição, obrigado!');
    }
}
