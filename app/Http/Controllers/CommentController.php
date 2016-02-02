<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    /**
     * CommentRepository object.
     *
     * @var CommentRepository $comment
     */
    protected $comment;

    /**
     * CommentController constructor.
     *
     * @param CommentRepository $comment
     */
    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

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
     * Store a newly created comment in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'post_id' => 'required|numeric',
            'parent' => 'required|numeric',
            'name' => 'required|alpha_num|max:30',
            'email' => 'required|email|max:100',
            'blog' => 'required|url|max:100',
            'content' => 'required'
        ]);

        if($validator->fails()){
            return back()
                    ->withErrors($validator, 'comment')
                    ->withInput($input);
        }


        $this->comment->store($input);

        return redirect()->back()->with('ok', 'comment successfully.');
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
