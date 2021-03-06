<?php

namespace App\Http\Controllers;

use App\Allocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Chapter;
use App\Comment;
use App\Project;
use Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project_supervisor=Allocation::where('user_id',Auth::user()->id)->get();
        $projects = Project::orderBy('title', 'asc')->get();
        $discussions = Comment::orderBy('created_at', 'desc')->get();
        return view('admin.comment.index', array('user' => Auth::user()), compact('discussions','project_supervisor','projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $discussions = Comment::orderBy('created_at', 'desc')->get();
        $chapters = Chapter::orderBy('created_at', 'asc')->get();
        return view('admin.comment.create', array('user' => Auth::user()), compact('chapters', 'discussions'));
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
            'comment' => 'required|string',
        ]);

        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->user_id = auth::user()->id;
        $comment->chapter_id = $request->chapter_id;
        $comment->commenttime = date('H:i:s');
        $comment->commentdate = date('d-m-Y');

        $comment->save();

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
        // $comments=Chapter::find($id)->comments;
        $discussions = Allocation::find($id)->project->chapters;

        return view('admin.comment.show', array('user' => Auth::user()), compact('discussions'));
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
