<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $supervisors = User::where('role_id', '3')->get();

        return view('admin.assignproject.index', compact('supervisors', 'user'));
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
            'supervisor_id' => 'required',
            'project_id' => 'required',
        ]);

        $inputs = $request->all();
        $project_ids = $inputs['project_id'];

        //Multiple insert queries
        foreach ($project_ids as $project_id) {
            Allocation::create([
                'user_id'    => $inputs['supervisor_id'],
                'project_id' => $project_id
            ]);

            $allocatedProjects = Project::find($project_id);
            $allocatedProjects->isallocated = '1';
            $allocatedProjects->save();
        }



        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $allocations = Allocation::where('project_id', $id)->delete();

        $allocatedProjects = Project::find($id);
        $allocatedProjects->isallocated = '0';
        $allocatedProjects->save();


        return redirect()->back();
    }
}
