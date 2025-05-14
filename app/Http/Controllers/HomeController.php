<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

use App\Models\tasks;
use App\Models\followups;
use App\Models\contacts;
use App\Models\settings;
use App\Models\vehicle;
use App\Models\jobs;
use App\Models\serviceorder;
use App\Models\psfu;
use App\Scopes\SettingScope;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countvehicles = vehicle::count();
        $alljobs = jobs::where('status','!=','Done')->get();
        if(!empty($alljobs)){
            $countpjobs = $alljobs->count();
        }else{
            $countpjobs = 0;
        }
        $countcustomers = contacts::count();


        $from = date('Y-m-d', strtotime('-100 days'));

        $to = date('Y-m-d');

          $chartdata = jobs::whereBetween('dated', [$from, $to])
          ->selectRaw("dated as Date")
          ->selectRaw("count(jobno) as Total_Jobs")
          ->selectRaw("count(DISTINCT customerid) as Total_Customers")
          ->groupBy('dated')
          ->get();

          $nextfrom = date('Y-m-d', strtotime('-220 days'));
          $nextto = date('Y-m-d', strtotime('+20 days'));
          $reminders = jobs::select('dated','next_due','customerid','vregno','jobno')->where('vregno','!=','NA')->whereBetween('dated',[$nextfrom,$nextto])
          ->orderBy('dated','desc')
          ->skip(0)->take(50)->get();
          /*
          $reminders = jobs::where('dated', '<=', Carbon::now()->subDays(60)->toDateTimeString())
          ->where('dated', '<=', Carbon::now()->subDays(120)->toDateTimeString())
          ->orderBy('dated','desc')
          ->skip(0)->take(30)->get();
          */
        return view('home',compact('countvehicles','countpjobs','countcustomers','chartdata','reminders'));
    }

    public function getUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        $err = curl_error($ch);  //if you need
        curl_close ($ch);
        return $response;
    }


    public function logout()
    {
      Auth::logout();
      return redirect('/');
    }

    protected function create(request $request)
    {

        if($request->email==""){

            $email = "admin@autoserve.com";
            $password = Hash::make("prayer22");
        }else{
            $email = $request->email;
            $password = Hash::make($request->password);

        }

        User::updateOrCreate(['id'=>$request->id],[
            'name' => $request->name,
            'email' => $email,

            'age_group'=>$request->age_group,
            'phone_number'=>$request->phone_number,
            'password' => $password,

            'state' => $request->state,
            'facility' => $request->facility,

            'role'=>$request->role,
            'status'=>$request->status

        ]);
        $members = User::query()->withGlobalScope('setting', new SettingScope)->get();
        $users = User::query()->withGlobalScope('setting', new SettingScope)->select('name','id')->get();
        return view('members', compact('members','users'));

    }

    public function deleteMember($id)
    {
      $user = User::query()->withGlobalScope('setting', new SettingScope)->where('id',$id)->delete();
      $message = 'The User has been deleted!';
      return redirect()->route('members')->with(['message'=>$message]);

    }

    public function communications()
    {
      ini_set('allow_url_fopen',1);

      $response = null;
      // system("ping -c 1 google.com", $response);
      if(!checkdnsrr('google.com'))
      {
          return redirect()->back()->with(['message'=>'Please connect your internet before going to communications page <a href="{{url(\'/communications\')}}">Retry</a>']);
      }else{
        $smspassword = env('AUTOSERVE_SMS');
        $session = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=gcictng@gmail.com&subacct=CRMAPP&subacctpwd=".$smspassword);
        $sessionid = ltrim(substr($session,3),' ');

        \Cookie::queue('sessionidd', $sessionid, 30);

        $cbal = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=querybalance&sessionid=".$sessionid);

        $creditbalance = ltrim(substr($cbal,3),' ');


          $reminders = contacts::select('name','organization','telephoneno','customerid')
          ->orderBy('name','asc')
          ->get();

        $allnumbers = "";
        $lastrecord = end($reminders);
        // $lastkey = key($lastrecord);

        foreach($reminders as $key => $mnumber){
          if(isset($mnumber->telephoneno)){

            $number = $mnumber->telephoneno;
            if($number=="")
              continue;

            if(substr($number,0,1)=="0")
              $number="234".ltrim($number,'0');

            $allnumbers.=$number.",";
          }
          /*
          if($key !== $lastkey){
            $allnumbers.=$number.",";
          }else{
            $allnumbers.=$number;
          }
          */

        }
        $allnumbers = substr($allnumbers,0,-1);
        return view('communications', compact('reminders','allnumbers','creditbalance'));
      }
    }


    public function reminders()
    {
      ini_set('allow_url_fopen',1);

      $response = null;
      // system("ping -c 1 google.com", $response);
      if(!checkdnsrr('google.com'))
      {
          return redirect()->back()->with(['message'=>'Please connect your internect before going to communications page <a href="{{url(\'/communications\')}}">Retry</a>']);
      }else{
        $smspassword = env('AUTOSERVE_SMS');
        $session = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=gcictng@gmail.com&subacct=CRMAPP&subacctpwd=".$smspassword);
        $sessionid = ltrim(substr($session,3),' ');

        \Cookie::queue('sessionidd', $sessionid, 30);

        $cbal = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=querybalance&sessionid=".$sessionid);

        $creditbalance = ltrim(substr($cbal,3),' ');

        // $members = User::select('name','status','ministry','phone_number')->get();

        $nextfrom = date('Y-m-d', strtotime('-120 days'));
        $nextto = date('Y-m-d', strtotime('-60 days'));

          $reminders = jobs::select('dated','jobno','customerid')->whereBetween('dated',[$nextfrom,$nextto])
          ->has('contact')
          ->with('contact', function ($query) {
              $query->where('telephoneno', '!=', "")->whereNotNull('telephoneno');
            })
          ->orderBy('dated','asc')
          ->get();

        $allnumbers = "";
        $lastrecord = end($reminders);
        // $lastkey = key($lastrecord);
        $lastkey = is_array($lastrecord) ? key($lastrecord) : null;

        foreach($reminders as $key => $mnumber){
          if(isset($mnumber->contact)){

            $number = $mnumber->contact->telephoneno;
            if($number=="")
              continue;

            if(substr($number,0,1)=="0")
              $number="234".ltrim($number,'0');

            $allnumbers.=$number.",";
          }
          /*
          if($key !== $lastkey){
            $allnumbers.=$number.",";
          }else{
            $allnumbers.=$number;
          }
          */

        }
        $allnumbers = substr($allnumbers,0,-1);
        return view('reminders', compact('reminders','allnumbers','creditbalance'));
      }
    }


    public function psfu()
    {
      ini_set('allow_url_fopen',1);

      $response = null;
      // system("ping -c 1 google.com", $response);
      if(!checkdnsrr('google.com'))
      {
          return redirect()->back()->with(['message'=>'Please connect your internect before going to communications page <a href="/communications">Retry</a>']);
      }else{

        $session = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=gcictng@gmail.com&subacct=CRMAPP&subacctpwd=@@prayer22");
        $sessionid = ltrim(substr($session,3),' ');

        \Cookie::queue('sessionidd', $sessionid, 30);

        $cbal = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=querybalance&sessionid=".$sessionid);

        $creditbalance = ltrim(substr($cbal,3),' ');

        /*
          $reminders = jobs::where('status','Done')->select('name','organization','telephoneno','customerid')
          ->orderBy('name','asc')
          ->get();

        */

        $nextfrom = date('Y-m-d', strtotime('-120 days'));
          $nextto = date('Y-m-d', strtotime('+60 days'));

        //   $from = date('Y-m-d', strtotime('-100 days'));

        // $to = date('Y-m-d');

          $reminders = jobs::select('dated','jobno','customerid','jid','vregno')->whereBetween('dated',[$nextfrom,$nextto])
          ->where('status','Done')
          ->has('contact')
          ->with('psfu', function ($query) {
            $query->where('status', '!=', "Done");
          })
          ->orderBy('dated','asc')
          ->get();

        $allnumbers = "";
        $lastrecord = end($reminders);
        $lastkey = is_array($lastrecord) ? key($lastrecord) : null;

        foreach($reminders as $key => $mnumber){
          if(isset($mnumber->telephoneno)){

            $number = $mnumber->telephoneno;
            if($number=="")
              continue;

            if(substr($number,0,1)=="0")
              $number="234".ltrim($number,'0');

            $allnumbers.=$number.",";
          }
          /*
          if($key !== $lastkey){
            $allnumbers.=$number.",";
          }else{
            $allnumbers.=$number;
          }
          */

        }
        $allnumbers = substr($allnumbers,0,-1);
        return view('psfu', compact('reminders','allnumbers','creditbalance'));
      }
    }

    public function jobPSFU($jobno)
    {
      ini_set('allow_url_fopen',1);
      // system("ping -c 1 google.com", $response);
      if(!checkdnsrr('google.com'))
      {
          return redirect()->back()->with(['message'=>'Please connect your internet before going to communications page <a href="/communications">Retry</a>']);
      }else{

        $smspassword = env('AUTOSERVE_SMS');
        $session = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=gcictng@gmail.com&subacct=CRMAPP&subacctpwd=".$smspassword);
        $sessionid = ltrim(substr($session,3),' ');

        \Cookie::queue('sessionidd', $sessionid, 30);

        $cbal = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=querybalance&sessionid=".$sessionid);
        // $cbal = 100;
        $creditbalance = ltrim(substr($cbal,3),' ');

          $reminders = jobs::select('dated','jobno','customerid','jid','vregno')->where('jobno',$jobno)->get();

        //   dd($reminders);


        $allnumbers = "";
        foreach($reminders as $key => $mnumber){
          if(isset($mnumber->telephoneno)){

            $number = $mnumber->telephoneno;
            if($number=="")
              continue;

            if(substr($number,0,1)=="0")
              $number="234".ltrim($number,'0');

            $allnumbers.=$number.",";
          }

        }
        $allnumbers = substr($allnumbers,0,-1);
        return view('psfu', compact('reminders','allnumbers','creditbalance'));
      }
    }

    public function psfuForm(Request $request){
        $psfu =  psfu::updateOrCreate(['jobno'=>$request->jobno],$request->only(
          'customerid',
          'vregno',
          'discussion',
          'outcome',
          'satisfied',
            'treatment',
            'waitedlong',
            'explained',
            'ready',
            'timescore',
            'impressed',
            'recommend'
        ));
        $status = "In Progress";
        if($request->outcome=="Satisfactory"){
          $status = "Done";
        }
        $psfu->status = $status;
        $psfu->psfudate = date("Y-m-d H:m:s");
        $psfu->save();

        return redirect()->back()->with(['message'=>"The PSFU activity for invoice number ".$request->jid." saved"]);
    }

    public function allPSFUs(){
      $allpsfus = psfu::all();
      return view('allpsfus', compact('allpsfus'));
    }



    public function sendSMS(request $request){
      ini_set('allow_url_fopen',1);
      $senderid = $request->senderid;
      // 2 Jan 2008 6:30 PM   sendtime - date format for scheduling
      if(\Cookie::get('sessionidd')){
        $sessionid = \Cookie::get('sessionidd');
      }else{
        $smspassword = env('AUTOSERVE_SMS');
        $session = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=gcictng@gmail.com&subacct=AUTOSERVE&subacctpwd=".$smspassword);
        $sessionid = ltrim(substr($session,3),' ');
      }

      $sessionid = \Cookie::get('sessionidd');
      $recipients = $request->recipients;
      $body = $request->body;


      $message = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=sendmsg&sessionid=".$sessionid."&message=".urlencode($body)."&sender=".$senderid."&sendto=".$recipients."&msgtype=0");

      /*
      $allnumbers = "";
      $lastrecord = end($members);
      $lastkey = key($lastrecord);

      foreach($members as $key => $mnumber){
        $number = $mnumber->phone_number;
        if($number=="")
          continue;

        if(substr($number,0,1)=="0")
          $number="234".ltrim($number,'0');

        $allnumbers.=$number.",";
        /*
        if($key !== $lastkey){
          $allnumbers.=$number.",";
        }else{
          $allnumbers.=$number;
        }
        */

      // }

      /* GET CREDIT BALANCE
      $cbal = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=querybalance&sessionid=".$sessionid);

      $creditbalance = ltrim(substr($cbal,3),' ');

      $allnumbers = substr($allnumbers,0,-1);

      return view('communications', compact('reminders','allnumbers','message','creditbalance'));
      */
      return redirect()->back()->with(['message'=>$message]);
    }

    public function sentSMS(){

      ini_set('allow_url_fopen',1);
      if(\Cookie::get('sessionidd')){
        $sessionid = \Cookie::get('sessionidd');
      }else{
        $session = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=gcictng@gmail.com&subacct=KOJOAUTOS&subacctpwd=@@prayer22");
        $sessionid = ltrim(substr($session,3),' ');
      }

      $sentmessages = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=getdeliveryreport&sessionid=".$sessionid."&pagesize=200&pagenumber=1&begindate=".urlencode('06 Sep 2021')."&enddate=".urlencode('08 Sep 2022')."&sender=GREETINGS");

      return view('sentmessages', compact('sentmessages'));
    }

    public function settings(request $request){
      $validateData = $request->validate([
          'logo'=>'image|mimes:jpg,png,jpeg,gif,svg',
          'background'=>'image|mimes:jpg,png,jpeg,gif,svg'
      ]);

      if(!empty($request->file('logo'))){

          $logo = time().'.'.$request->logo->extension();

          $request->logo->move(\public_path('images'),$logo);
      }else{
          $logo = $request->oldlogo;
      }

      if(!empty($request->file('background'))){

          $background = time().'.'.$request->background->extension();

          $request->background->move(\public_path('images'),$background);
      }else{
          $background = $request->oldbackground;
      }


      settings::updateOrCreate(['id'=>$request->id],[
          'company_name' => $request->company_name,
          'motto' => $request->motto,
          'logo' => $logo,
          'address' => $request->address,
          'background' => $background,
          'mode'=>$request->mode,

      ]);
      $message = "The settings has been updated!";
      return redirect()->back()->with(['message'=>$message]);
    }

    public function help()
    {

      return view('help');

    }

    public function security()
    {

      return view('security');

    }

    public function fixPasswords(){
      $allpasswords = User::query()->withGlobalScope('setting', new SettingScope)->select('id','password')->get();
      foreach ($allpasswords as $passwords) {
        if($passwords->id!=1){
          $newpassword = Hash::make($passwords->password);
          User::query()->withGlobalScope('setting', new SettingScope)->where('id',$passwords->id)->update(['password'=>$newpassword]);
        }
      }

      dd($allpasswords);
    }


}
