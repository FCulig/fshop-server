<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Mail\RegistrationMail;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
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
        //
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
        $user = User::findOrFail($id);

        if (isset($user)) {
            if ($user->profile_img_url != 'default.png') {
                File::delete(public_path("/storage/images/profile-pictures/" . $user->profile_img_url));
            }

            if($user->delete()){
                return new UserResource($user);
            }
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'birth_date' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'profile_image' => 'image|nullable|max:1999',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = new User;

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->birth_date = $request->birth_date;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = 3;

        if ($request->hasFile('profile_image')) {
            $filenameWithExt = $request->file('profile_image')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extenstion = $request->file('profile_image')->getClientOriginalExtension();

            $filenameToStore = $filename . '_' . time() . '.' . $extenstion;

            $request->file('profile_image')->storeAs('public/images/profile-pictures', $filenameToStore);
        } else {
            $filenameToStore = 'public/default.png';
        }

        $user->profile_img_url = $filenameToStore;

        if ($user->save()) {
            Mail::to('email@email.com')->send(new RegistrationMail());
            return new UserResource($user);
        }
    }
}
