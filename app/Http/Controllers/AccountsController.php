<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\settings;

class AccountsController extends Controller
{
    /**
     * This controller will be use to manage all the Accounts on Auto Serve System.
     * 
     *  - View Accounts
     *  - Manage accounts
     *  - Manage accounts subscription
     * 
     */


    public function index()
    {
        $users = User::whereHas('setting')->with('setting')->get();
        return view('accounts.index', compact('users'));
    }

    public function show($user)
    {
        // Find the user by ID
        $user = User::findOrFail($user);
        return view('accounts.show', compact('user'));
    }

    public function edit($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        // Check if the user has settings
        if (!$user->setting) {
            return redirect()->route('accounts.index')->with('error', 'Settings not found for this user.');
        }
        // Pass the user and settings to the view
        return view('accounts.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->all();

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user details
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        // Update the settings details
        $settings = settings::where('user_id', $id)->first();
        if ($settings) {
            $settings->update([
                'company_name' => $validatedData['company_name'],
                'address' => $validatedData['address'],
                'deployment_type' => $validatedData['deployment_type'],
            ]);
        }

        return redirect()->route('accounts.index')->with('success', $user->name . ': Account updated successfully.');
    }



}
