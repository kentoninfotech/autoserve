<?php

namespace App\Http\Controllers;

use App\Models\tasks;
use Illuminate\Http\Request;
use App\Models\followups;
use App\Models\User;
use App\Scopes\SettingScope;
use Auth;
use Artisan;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role=="Admin"){
            $tasks = tasks::orderBy('status', 'DESC')->paginate(50);
        }else{
            $tasks = tasks::where('assigned_to',Auth::user()->id)->orderBy('status', 'DESC')->paginate(50);
        }

        $users = User::query()->withGlobalScope('setting', new SettingScope)->select('id','name')->get();

        return view('tasks', compact('tasks','users'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        tasks::updateOrCreate(['id'=>$request->id],[
            'title' => $request->title,
            'date' => $request->date,
            'category' => $request->category,
            'activities' => $request->activities,
            'status' => $request->status,
            'assigned_to'=>$request->assigned_to,
            'member'=>$request->assigned_to
        ]);

        $tasks = tasks::all();
        if($request->phone_number!=""){

            $recipients = $request->phone_number;
            if(substr($recipients,0,1)=="0"){
                $recipients="234".ltrim($recipients,'0');
            }
            // SEND SMS
            // 2 Jan 2008 6:30 PM   sendtime - date format for scheduling
            if(\Cookie::get('sessionidd')){
                $sessionid = \Cookie::get('sessionidd');
            }else{
                $session = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=gcictng@gmail.com&subacct=CRMAPP&subacctpwd=@@prayer22");
                $sessionid = ltrim(substr($session,3),' ');
            }

            $body = $request->title;


            $message = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=sendmsg&sessionid=".$sessionid."&message=".urlencode($body)."&sender=REMINDER&sendto=".$recipients."&msgtype=0");
        }
        return redirect()->back()->with(['tasks'=>$tasks,'message'=>'Task sent successfully!']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(tasks $tasks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(tasks $tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tasks $tasks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        tasks::findOrFail($id)->delete();
        $message = 'The task has been deleted!';
        return redirect()->route('tasks')->with(['message'=>$message]);
    }

    public function deletefollowup($id,$member)
    {
        followups::findOrFail($id)->delete();
        $message = 'The followup activity has been deleted!';
        return redirect()->route('tasks',['id'=>$member])->with(['message'=>$message]);
    }

    public function completetask($id)
    {
        $task = tasks::where('id',$id)->first();
        $task->status = 'Completed';
        $task->save();

        $message = 'The task has been updated!';
        return redirect()->route('tasks')->with(['message'=>$message]);
    }

    public function inprogresstask($id)
    {
        $task = tasks::where('id',$id)->first();
        $task->status = 'In Progress';
        $task->save();

        $message = 'The task has been updated!';
        return redirect()->route('tasks')->with(['message'=>$message]);
    }

    public function newfollowup(Request $request)
    {
        followups::updateOrCreate(['id'=>$request->id],[
            'title' => $request->title,
            'member' => $request->member,
            'date' => $request->date,
            'type' => $request->type,
            'discussion' => $request->discussion,
            'nextaction' => $request->nextaction,
            'nextactiondate' => $request->nextactiondate,
            'status' => $request->status,
            'assigned_to'=>$request->assigned_to
        ]);

        tasks::updateOrCreate(['id'=>$request->id],[
            'title' => $request->title,
            'date' => $request->nextactiondate,
            'category' => $request->type,
            'activities' => $request->nextaction,
            'status' => $request->status,
            'assigned_to'=>$request->assigned_to,
            'member'=>$request->member
        ]);


        $tasks = tasks::paginate(50);
        $followups = followups::paginate(50);

        if($request->phone_number!=""){

            $recipients = $request->phone_number;
            if(substr($recipients,0,1)=="0"){
                $recipients="234".ltrim($recipients,'0');
            }
            // SEND SMS
            // 2 Jan 2008 6:30 PM   sendtime - date format for scheduling
            if(\Cookie::get('sessionidd')){
                $sessionid = \Cookie::get('sessionidd');
            }else{
                $session = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=gcictng@gmail.com&subacct=CRMAPP&subacctpwd=@@prayer22");
                $sessionid = ltrim(substr($session,3),' ');
            }

            $sessionid = \Cookie::get('sessionidd');


            $body = $request->title;


            $message = $this->getUrl("http://www.smslive247.com/http/index.aspx?cmd=sendmsg&sessionid=".$sessionid."&message=".urlencode($body)."&sender=CHURCH&sendto=".$recipients."&msgtype=0");
        }

        return redirect()->back()->with(['tasks'=>$tasks,'followups'=>$followups]);

    }

    public function Artisan1($command) {
        $artisan = Artisan::call($command);
        $output = Artisan::output();
        return dd($output);
    }

    public function Artisan2($command, $param) {

        $output = Artisan::call($command.":".$param);

        // $artisan = Artisan::call($command,['flag'=>$param]);
        // $output = Artisan::output();
        return dd($output);
    }



}
