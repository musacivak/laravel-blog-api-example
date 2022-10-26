<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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
            $user = new User;
            $user->name = "API USER";
            $user->email = "api@musacivak.com";
            $user->password = Hash::make('test-password');
            $user->save();

            $success['token'] = $user->createToken('api')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User created successfully', $request, $route);
        } catch (\Exception $e){
            return $this->sendError('Unauthorised', ['error' => 'Unauthorised'], 401);
        }

    }

    public function signin(Request $request, Route $route)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)){
            $user = Auth::user();
            $success['token'] = $user->createToken('api')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'Token created successfully', $request, $route);
        } else {
            return $this->sendError('Unauthorised', $request, $route, ['error' => 'Unauthorised'], 401);
        }
    }

}
