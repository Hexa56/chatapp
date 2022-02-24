<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\User;
use Hash;
use Validator;
use App\Models\Migration;
use App\Events\handler;
use App\Events\Tick;
use App\Events\ghandler;
use App\Events\Status;
use App\Events\msgdel; 
use App\Models\message;
use App\Models\grouppeople;
use App\Models\groups;
use App\Models\groupchat;

Use Alert;

class UserController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $ch = User::where('email','=',$request->email)->get()->first();
        if(Hash::check($request->password, $ch->password))
        {
            $request->session()->put('user', $ch->name);
            $request->session()->put('user_id', $ch->id);
            event(new Status('online',$ch->id));
            $ch->status = 1;
            $ch->save();
            return redirect("/home");
        }
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);
   
        // $credentials = $request->only('email', 'password');
        // if (Auth::attempt($credentials)) {
        //     return redirect('/home')->withSuccess('You have Successfully logged In');
        // }
        // session()->flash('message','Oppes! You have entered invalid credentials');
        // return redirect("/");
        
    }
    
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect()->back()->with('status','Registration Successfull');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
   
    public function home()
    {
        $data = User::all();

        return view('chat', ['data' => $data]);

    }

    public function select($id)
    {
        $selecteduser = User::find($id);
        $data = User::all();
        $select = User::find(request()->session()->get('user_id'));
        $select->selected = $id;
        $select->save();
        $check = User::where('id','=',$id)->where('selected','=',request()->session()->get('user_id'))->get()->first();
        if($check)
        $double = 1;
        else
        $double = '';

        $seen = message::where("sender",'=',$selecteduser->name)->where("recevier",'=',request()->session()->get('user'))->update(['seen'=>1]);
        event(new Tick($id, request()->session()->get('user_id')));
        return view('chat', ['data' => $data, 'user' => $selecteduser, 'double'=>$double]);
    }

    public function gselect($id)
    {
        $selecteduser = groups::find($id);
        $data = User::all();

        return view('chat', ['data' => $data, 'user' => $selecteduser,'group'=>'on']);
    }


    public function settings()
    {
        $user = User::find(request()->session()->get('user_id'));
        return view('settings',['user' => $user]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function change()
    {

      return view('auth.changepwd');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
          'current_password' => 'required',
          'password' => 'required|string|min:6|confirmed',
          'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            session()->flash('message','Current Password does not Match');
            return back();
        }

        $user->password = Hash::make($request->password);
        $user->save();
        session()->flash('message','Password Changed Successfully');
        return back();
    }

    public function upload(Request $request)
    {
        if($request->hasFile('image')){
            $filename = $request->image->getClientOriginalName();
            $request->image->storeAs('images',$filename,'public');
            // Auth()->user()->update(['image'=>$filename]);
            $update = User::find($request->session()->get('user_id'));
            $update->image=$filename;
            $update->save();
        }
        Alert::success('Success', 'Profile Picture Updated Successfully');
        return redirect()->back();
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name' =>'required|min:4|string|max:255',
            'email'=>'required|email|string|max:255|unique:users'
        ]);
        $user = User::find($request->session()->get('user_id'));
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->save();
        Alert::success('Success', 'Account Settings Updated Successfully');
        return redirect()->back();

    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        
        $s = User::find(request()->session()->get('user_id'));
        event(new Status('away',$s->id));
        $s->status = 0;
        $s->selected = 0;
        $s->save();
        Session::flush();
        Auth::logout();
        
        return Redirect('/')->withSuccess('Logout Successfull');
    }

    public function chat()
    {
        if(isset(request()->gid))
        {
            $add =  new groupchat();
            $add->sender = request()->sname;
            $add->group_id = request()->gid;
            $add->message = request()->gmsg;
            $add->save();
            return event(new ghandler(request()->sname, request()->gmsg, $add->id, request()->gname, $add->created_at->format('Y-m-d h:i:s a')));
        }
        else
        {
        $add =  new message();
        $add->sender = request()->name;
        $add->recevier = request()->reciver;
        if(request()->hasFile('file'))
        {
            $imgcheck = ['jpg', 'jpeg', 'png'];
            $video = ['mp4','gif','mkv'];
            $audio = ['mp3','wav'];
            $name = request()->file->getClientOriginalName();
            $extension = request()->file->getClientOriginalExtension();
            request()->file->storeAs('public/docs', $name);
            if(in_array($extension, $imgcheck))
            $msg = "<a target='_new' href=/storage/docs/".$name."><img width='300' height='300' src=/storage/docs/".$name."></a>";
            else if(in_array($extension, $video))
            {
            $msg = '<video width="400" controls>
            <source src=/storage/docs/'.$name.' type="video/mp4">
            </video>';
            }
            else if(in_array($extension, $audio))
            {
            $msg = '<audio width="400" controls>
            <source src=/storage/docs/'.$name.' type="video/mp4">
            </audio>';
            }
            else
            $msg = "<a target='_new' href=/storage/docs/".$name."><img width='100' height='100' src=https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSFBVgrCZUwUT9V-rLSpQPj10C8reI2lUodOA&usqp=CAU></a>";
            $add->message = $msg;
        }
        else
        {
            $add->message = request()->msg;
            $msg = request()->msg;
        }
        
        $ch = User::where('id','=',request()->rev)->where('selected','=',request()->session()->get('user_id'))->get()->first();
        if($ch)
        $add->seen = 1;

        $add->save();
        $time = date('d-m-Y h:i:s a');
        return event(new handler(request()->name, $msg, request()->reciver, $time, $add->id,request()->dd));
        }
    }
public function msgdel($id)
{
    $del = message::find($id);
    $del->delete();
    event(new msgdel($id));
    return redirect()->back();
} 

public function typing($id)
{
    event(new Status('typing', $id));
}
public function notyping($id)
{
    event(new Status('notyping', $id));
}
}

