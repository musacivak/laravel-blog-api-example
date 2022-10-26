<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            $posts = Comment::all();

            return $this->sendResponse($posts, 'Comment list successfully');
        } catch (\Exception $e){
            return $this->sendError('something went wrong', [] , 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        //
        try{
            $validated = $request->validated();

            $comment = new Comment();
            $comment->post_id = $validated['title'];
            $comment->name = $validated['description'];
            $comment->email = $validated['keywords'];
            $comment->comment = $validated['tags'];
            $comment->ip_address = $validated['slug'];
            $comment->save();

            return $this->sendResponse($comment, 'Comment create successfully');

        } catch (\Exception $e){
            return $this->sendError('something went wrong', [] , 400);
        }
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
        try{
            $comment = Comment::find($id);

            if ($comment){
                return $this->sendResponse($comment, 'Comment show successfully');
            } else {
                return $this->sendError('Bad Request', [] , 400);
            }
        } catch (\Exception $e){
            return $this->sendError('something went wrong', [] , 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request)
    {
        //
        try{
            $validated = $request->validated();
            $comment = Comment::find($validated['id']);
            $comment->post_id = $validated['title'];
            $comment->name = $validated['description'];
            $comment->email = $validated['keywords'];
            $comment->comment = $validated['tags'];
            $comment->ip_address = $validated['slug'];
            $comment->save();

            return $this->sendResponse($comment, 'Comment update successfully');
        } catch (\Exception $e){
            return $this->sendError('something went wrong', [] , 400);
        }
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
        try{
            $comment = Comment::find($id);

            if ($comment){
                $comment->delete();
                return $this->sendResponse($comment, 'Comment destroy successfully');
            } else {
                return $this->sendError('Bad Request', [] , 400);
            }
        } catch (\Exception $e){
            return $this->sendError('something went wrong', [] , 400);
        }
    }
}
