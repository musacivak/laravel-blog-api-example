<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Route $route)
    {
        //
        try {
            $posts = Post::with('comments')->get();

            return $this->sendResponse($posts, 'Posts list successfully', $request, $route);
        } catch (\Exception $e){
            return $this->sendError('something went wrong', $request, $route, [] ,400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, Route $route)
    {
        //
        try{
            $validated = $request->validated();

            $post = new Post;
            $post->title = $validated['title'];
            $post->description = $validated['description'];
            $post->keywords = $validated['keywords'];
            $post->tags = $validated['tags'];
            $post->content = $validated['content'];
            $post->slug = $validated['slug'];
            $post->status = $validated['status'];
            $post->save();

            return $this->sendResponse($post, 'Post create successfully', $request, $route);

        } catch (\Exception $e){
            return $this->sendError('something went wrong', $request, $route, [] ,400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request, Route $route)
    {
        //
        try{
            $post = Post::find($id);

            if ($post){
                return $this->sendResponse($post, 'Post show successfully');
            } else {
                return $this->sendError('Bad Request', [] , 400, $request, $route);
            }
        } catch (\Exception $e){
            return $this->sendError('something went wrong', $request, $route, [] , 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Route $route)
    {
        //
        try{
            $validated = $request->validated();
            $post = Post::find($validated['id']);
            $post->title = $validated['title'];
            $post->description = $validated['description'];
            $post->keywords = $validated['keywords'];
            $post->tags = $validated['tags'];
            $post->content = $validated['content'];
            $post->slug = $validated['slug'];
            $post->status = $validated['status'];
            $post->save();

            return $this->sendResponse($post, 'Post update successfully', $request, $route);
        } catch (\Exception $e){
            return $this->sendError('something went wrong', $request, $route, [] , 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, Route $route)
    {
        //
        try{
            $post = Post::find($id);

            if ($post){
                $post->delete();
                return $this->sendResponse($post, 'Post destroy successfully', $request, $route);
            } else {
                return $this->sendError('Bad Request', $request, $route, [] , 400);
            }
        } catch (\Exception $e){
            return $this->sendError('something went wrong', $request, $route, [] , 400);
        }
    }
}
