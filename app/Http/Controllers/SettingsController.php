<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountWelcomeMail;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function companyRegister(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'address' => 'nullable|string',
            'deployment_type' => 'required|string|max:50',
        ]);


        // Create a new User instance
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'role' => 'Super',
            'status' => 'Active',
            'password' => Hash::make('auto123'), // Set a default password
        ]);

        // Save the validated data to the database
        $settings = new settings();
        $settings->user_id = $user->id;
        $settings->company_name = $validatedData['company_name'];
        $settings->address = $validatedData['address'];
        $settings->mode = 'Active'; // Set default mode
        $settings->deployment_type = $validatedData['deployment_type'];
        $settings->save();

        // Update the user with the settings ID
        $user->setting_id = $settings->id;
        $user->save();

        // Send email to the user
        Mail::to($user->email)->queue((new AccountWelcomeMail($user)));


        
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Company registered successfully!',
                'instructions' => 'Please check your email (and your spam/junk folder, just in case it lands there) for further instructions on how to proceed.'
            ]);
        }

        return redirect()->back()->with('success', 'Company registered successfully!');
    }

    public function webEnquiry(Request $request){

        // Send email to the AutoServe team
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'user_message' => $request->input('message'), 
        ];

        Mail::queue('emails.enquiry', $data, function ($message) use ($data) {
            $message->from($data['email'], $data['name']);
            $message->to(env('MAIL_USERNAME'), 'AutoServe | Web Enquiry');
            $message->subject($data['subject']);
            $message->replyTo($data['email'], $data['name']);
        });

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you shortly.');

    

    }

    // View Account Settings 
    public function accountSettings()
    {
        $user = auth()->user();
        $settings = $user->setting_id ? settings::find($user->setting_id) : settings::where('user_id', $user->settings->id)->first();
        return view('account-settings', compact('user', 'settings'));
    }

    // Update Account Details
    public function updateAccount(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'nullable|email',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:100',
            'header' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
        ]);

        // Image path
        $image_path = public_path("images/");

        // Update settings
        $settings = $user->settings ?? new \App\Models\settings();
        $settings->company_name = $validated['company_name'];
        $settings->company_email = $validated['company_email'];
        $settings->address = $validated['address'] ?? '';
        $settings->phone_number = $validated['phone_number'] ?? '';
        if ($request->hasFile('header')) {
            $image = $request->file('header');
            $imageName = now()->format('Y_m_d') . '_' . $image->getClientOriginalName();
            $headerPath = $image->move($image_path, $imageName);
            $settings->header = basename($headerPath);
        }
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = now()->format('Y_m_d') . '_' . $image->getClientOriginalName();
            $logoPath = $image->move($image_path, $imageName);
            $settings->logo = basename($logoPath);
        }
        $settings->primary_color = $validated['primary_color'] ?? $settings->primary_color;
        $settings->secondary_color = $validated['secondary_color'] ?? $settings->secondary_color;
        $settings->save();

        return back()->with('message', 'Account details updated successfully.');
    }

    // Update Password
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $validator = \Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:5|confirmed',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator, 'changePassword')->withInput();
        }
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'], 'changePassword')->withInput();
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with('message', 'Password updated successfully.');
    }

    // Update SMS Config
    public function updateSmsConfig(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'sms_api_key' => 'required|string',
            'sms_api_secret' => 'required|string',
        ]);
        $settings = $user->setting_id ? settings::find($user->setting_id) : settings::where('user_id', $user->settings->id)->first();
        $settings->sms_api_key = $validated['sms_api_key'];
        $settings->sms_api_secret = $validated['sms_api_secret'];
        $settings->save();
        return back()->with('message', 'SMS configuration updated successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(settings $settings)
    {
        //
    }
}
