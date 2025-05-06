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
