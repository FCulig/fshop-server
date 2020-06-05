<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Cart;
use App\Http\Resources\User as UserResource;
use App\PromotionRequest;
use App\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource($this->getUserWithId($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->getUserWithId($id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->birth_date = $request->birth_date;

        if ($user->email != $request->email) {
            $checkUser = $this->getUserWithEmail($request->email);
            if ($checkUser->count() == 0) {
                $user->email = $request->email;
            } else {
                return response()->json(['message' => 'email']);
            }
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_img_url != 'default.png') {
                File::delete(public_path("/storage/images/profile-pictures/" . $user->profile_img_url));
            }
            $user->profile_img_url = $this->getFileNameToStoreProfileImage($request);
        }

        if ($user->save()) {
            return new \App\Http\Resources\User($user);
        }
    }

    public function getAllUsersProducts($id)
    {
        $products = $this->getUserWithId($id)->products;
        $productsResources = array();
        foreach ($products as $product) {
            $productsResources[] = new \App\Http\Resources\Product($product);
        }
        return $productsResources;
    }

    public function getUsersProducts($id)
    {
        $products = $this->getUserWithId($id)->products->where('quantity', '>', 0);
        $productsResources = array();
        foreach ($products as $product) {
            $productsResources[] = new \App\Http\Resources\Product($product);
        }
        return $productsResources;
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
            //TODO: brisanje komentara, proizvoda, transakcija? - jer se i drugom korisniku obriše
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

    public function getUserWithId($id)
    {
        return User::FindOrFail($id);
    }

    public function usersCart($userId)
    {
        return new Cart($this->getUserWithId($userId)->cart);
    }

    public function register(StoreUserRequest $request)
    {
        $user = $this->createUser($request);
        return $this->saveUser($user);
    }

    private function createUser($request)
    {
        $user = new User($request->all());
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
        if ($user->save()) {
            $cartController = new CartsController();
            $cartController->store($user->id);
            //TODO: fix mailing
            //Mail::to('email@email.com')->send(new RegistrationMail());
            return new UserResource($user);
        }
    }

    public function changePassword(ChangePasswordRequest $request, $userId)
    {
        if (Auth::guard('api')->check()) {
            if (\Hash::check($request->old_password, Auth::guard('api')->user()->password)) {
                $user = User::findOrFail(Auth::guard('api')->user()->id);
                $user->password = bcrypt($request->password);

                if($user->save()) {
                    return $user;
                }
            } else {
                return response()->json("Stara lozinka nije točna!", 422);
            }
        } else {
            return "Nije loginan";
        }
        //return redirect()->to('/')->with('alert-success','Password changed successfully !');
        //return $request->all();
    }

    public function promote($id)
    {
        $user = $this->getUserWithId($id);
        $user->role_id = 2;
        if ($user->save()) {
            return $user;
        }
    }

    public function demote($id)
    {
        $user = $this->getUserWithId($id);
        $user->role_id = 3;
        if ($user->save()) {
            return $user;
        }
    }

    public function isEligibleForPromotion($id)
    {
        $promotrionRequests = PromotionRequest::all()->where('user_id', $id);

        if (sizeof($promotrionRequests) > 0 && User::findOrFail($id)->number_sold_items > 10) {
            return "true";
        } else {
            return "false";
        }
    }
}
