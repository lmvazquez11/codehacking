<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
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


        $input = $request->all();

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
        //return redirect('/admin/users');

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
        return view('admin.users.edit');
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
