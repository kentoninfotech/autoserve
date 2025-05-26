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
        $users = User::whereHas('setting')->with('setting')->where('role', 'Super')->get();
        return view('accounts.index', compact('users'));
    }

    public function show($user)
    {
        $user = User::findOrFail($user);
        return view('accounts.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        // Check if the user has settings
        if (!$user->setting) {
            return redirect()->route('accounts.index')->with('error', 'Settings not found for this user.');
        }
        
        return view('accounts.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->all();

        $user = User::findOrFail($id);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'facility' => $validatedData['facility'],
        ]);

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

    public function activateAccount($id)
    {
        $user = User::findOrFail($id);
        $setting = $user->setting;
        if ($setting) {
            $setting->status = 'Active';
            $setting->save();
        }
        return redirect()->route('accounts.index')->with('success', $setting->company_name . ': Account activated successfully.');
    }
    public function deactivateAccount($id)
    {
        $user = User::findOrFail($id);
        $setting = $user->setting;
        if ($setting) {
            $setting->status = 'Inactive';
            $setting->save();
        }
        return redirect()->route('accounts.index')->with('success', $setting->company_name . ': Account deactivated successfully.');
    }



}
