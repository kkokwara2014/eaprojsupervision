<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use Auth;
use App\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $allAdmins=User::where('role_id', '1')->count();
        $allProjectCoordinators=User::where('role_id', '2')->count();
        $allSupervisors=User::where('role_id', '3')->count();
        $allStudents=User::where('role_id', '4')->count();
        $allAllocatedProjects=Project::where('isallocated','1')->count();
        $allUnallocatedProjects=Project::where('isallocated','0')->count();

        return view('admin.index', compact('user','allAdmins','allProjectCoordinators','allSupervisors','allStudents','allAllocatedProjects','allUnallocatedProjects'));
    }

    public function admins()
    {
        $user = Auth::user();
        $admins = User::where('role_id', '1')->orderBy('created_at', 'desc')->get();
        $departments = Department::orderBy('name', 'asc')->get();

        return view('admin.admins.index', compact('user', 'admins', 'departments'));
    }

    public function activate($id)
    {
            $admin = User::find($id);
            $admin->isactive = '1';
            $admin->save();
    
            return redirect(route('admin.admins'));
        
    }
    public function deactivate($id)
    {
        
            $admin = User::find($id);
            $admin->isactive = '0';
            $admin->save();
    
            return redirect(route('admin.admins'));
        
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
        $this->validate($request, [
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'identitynumber' => 'required|string|unique:users',
            'gender' => 'required|string',
            'phone' => 'required|integer',
            'department_id' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|string|min:6|confirmed',

        ]);

        $user = new User;

        $user->lastname = $request->lastname;
        $user->firstname = $request->firstname;
        $user->othername = $request->othername;
        $user->identitynumber = $request->identitynumber;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->department_id = $request->department_id;
        $user->role_id = $request->role_id;
        $user->isactive = $request->isactive;

        $user->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = User::find($id);
        return view('admin.admins.show', array('user' => Auth::user()), compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
