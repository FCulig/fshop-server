<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Rules\ValidEmail;
use App\Rules\ValidUsername;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->getUserWithId($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (isset($user)) {
            if ($user->profile_img_url != 'default.png') {
                File::delete(public_path("/storage/images/profile-pictures/" . $user->profile_img_url));
            }

            if ($user->delete()) {
                return new UserResource($user);
            }
        }
    }

    public function getUserWithEmail($email)
    {
        return User::where('email', $email)->get();
    }

    public function getUserWithUsername($username)
    {
        return User::where('username', $username)->get();
    }

    public function getUserWithId($id){
        return User::FindOrFail($id);
    }

    public function register(Request $request)
    {
        $isValid = $this->validateUserCreation($request);

        if($isValid === true){
            $user = $this->createUser($request);
            return $this->saveUser($user);
        }else{
            return $isValid;
        }
    }

    private function validateUserCreation($request)
    {
        $validator = $this->makeRegisterRequestValidator($request);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 409);
        }

        return true;
    }

    private function makeRegisterRequestValidator($request)
    {
        return Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => ['required', new ValidUsername],
            'birth_date' => 'required',
            'email' => ['required','email', new ValidEmail],
            'password' => 'required',
            'c_password' => 'required|same:password',
            'profile_picture' => 'image|mimes:jpeg,jpg,png|nullable|max:1999',
        ]);
    }

    private function createUser($request)
    {
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->birth_date = $request->birth_date;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = 3;
        $user->profile_img_url = $this->getFileNameToStoreProfileImage($request);

        return $user;
    }

    private function getFileNameToStoreProfileImage($request)
    {
        if ($request->hasFile('profile_picture')) {
            $filenameToStore = $this->getFileName($request);
            $request->file('profile_picture')->storeAs('public/images/profile-pictures', $filenameToStore);
        } else {
            $filenameToStore = 'default.png';
        }

        return $filenameToStore;
    }

    private function getFileName($request)
    {
        $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('profile_picture')->getClientOriginalExtension();

        return $filename . '_' . time() . '.' . $extension;
    }

    private function saveUser($user)
    {
        //TODO: da return bude succes: user resource
        if ($user->save()) {
            //TODO: fix mailing
            //Mail::to('email@email.com')->send(new RegistrationMail());
            return new UserResource($user);
        }
    }
}
