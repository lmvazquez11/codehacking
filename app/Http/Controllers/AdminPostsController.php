<?php

namespace App\Http\Controllers;

use App\Post;
use App\Photo;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostsCreateRequest;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();
        //---compact
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        //---MXV, pass categories
        $categories = Category::pluck('name','id')->all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        //
        //---This will return all the values in an array (to test)
        //return $request->all();
        $input = $request->all();

        //---logged in user
        $user = Auth::user();
        //---check if the photo is there
        if($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();

            //---working with file, move it
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;
            //return "Working!";
        }

        //---chaining methods
        $user->posts()->create($input);

        return redirect('/admin/posts');


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
        //
    }
}
