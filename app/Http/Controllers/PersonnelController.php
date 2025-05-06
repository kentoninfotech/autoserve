<?php

namespace App\Http\Controllers;

use App\Models\personnel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Scopes\SettingScope;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personnels = personnel::all();
        return view('personnels', compact('personnels'));
    }

    public function Users()
    {
        $usersa = User::query()->withGlobalScope('setting', new SettingScope)->get();
        return view('users', compact('usersa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new-personnel');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // personnel::create($request->all());

        $personnel = personnel::updateOrCreate(['id'=>$request->id],
        $request->only(
            'surname',
            'firstname',
            'othernames',
            'designation',
            'phoneno',
            'email',
            'address',
            'department',
            'salary',
            'highestcert',
            
            'guarantor',
            'staffid',                    
            'dob',
            'stateoforigin',
            'maritalstatus',
            'empdate'            
        ));

        $newpassword = Hash::make($request->spassword);

        if($request->id > 0){
            // FOR UPDATES
            if($newpassword != $request->oldpassword){
                $personnel->password = $newpassword;
            }
        }else{
            // FOR NEW PERSONNEL
            $personnel->password = $newpassword;

            User::create([
                'name'=>$request->surname." ".$request->firstname." ".$request->othernames,
                'phone_number'=>$request->phoneno,
                'email'=>$request->email,
                'setting_id'=> Auth::user()->setting_id,
                'state'=>$request->stateoforigin,
                'status'=>"Active",
                'password'=>$newpassword,
                'role'=>$request->department
            ]);
        }

        $validateData = $request->validate([
            'picture'=>'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'cv'=>'image|mimes:jpg,png,jpeg,gif,svg,doc,docx,pdf|max:2048',
        ]);
        
        if(!empty($request->file('picture'))){
         
            $picture = time().'.'.$request->picture->extension();
          
            $request->picture->move(\public_path('images'),$picture);
        }else{
            $picture = $request->oldpicture;
        }
   
        if(!empty($request->file('cv'))){
            
            $cv = time().'.'.$request->cv->extension();
            
            $request->cv->move(\public_path('images'),$cv);
        }else{
            $cv = $request->oldcv;
        }

        $personnel->picture = $picture;
        $personnel->cv = $cv;

        $personnel->save();

        

        return redirect()->back()->with(['message'=>'The Personnel Record was saved successfully!']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function show(personnel $personnel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $personnel = personnel::where("id",$id)->first();
        return view('new-personnel', compact('personnel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, personnel $personnel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function destroy(personnel $personnel)
    {
        //
    }
}
