<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Photo;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::all();

        //---MXV - Return view for admin
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //---MXV Instead of lists we use pluck for the lists of roles
        $roles = Role::pluck('name','id')->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //To create the record
        //User::create($request->all());

        if(trim($request->password) == ''){
            $input = $request->except('password');
        } else {
            $input = $request->all();
            //---Crypt password
            $input['password'] = bcrypt($request->password);
        }

        if($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();

            //---MXV move file to images folder, if does not exist the folder is created
            $file->move('images',$name);

            $photo = Photo::create(['file' => $name]);

            $input['photo_id'] = $photo->id;
        }
        //---if there is no image,then...
        //---encrypt pass
        $input['password'] = bcrypt($request->password);
        User::create($input);

        //---verify if exists
        /* if($request->file('photo_id')){
            return "photo exists";
        } */

        //---MXV return data, receive all data to store
        return redirect('/admin/users');

        //---for debug process only
        //return $request->all();
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
        return view('admin.users.show');

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
        //---Find user
        $user = User::findOrFail($id);
        //---Pass role, use pluck to retrieve data instead of list
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //---MXV, we added UsersRequest to properly work the update
    public function update(UsersEditRequest $request, $id)
    {
        //---Get User
        $user = User::findOrFail($id);

        //---Check if the password is empty, otherwise it updates
        if(trim($request->password) == ''){
            $input = $request->except('password');
        } else {
            $input = $request->all();
            //---Crypt password
            $input['password'] = bcrypt($request->password);
        }

        //---Check for images to edit
        if($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            //---Create a photo
            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }

        //---Just update
        $user->update($input);

        return redirect('/admin/users');

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
