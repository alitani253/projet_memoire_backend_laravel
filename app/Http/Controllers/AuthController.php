<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
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
        //
    }

    public function register(Request $request)
    {
        $userdata = $request->all();
        $validator= Validator::make($userdata, [
            'nom' => 'required|max:55',
            'role' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'tel' => 'required|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'

        ]);

        if($validator->fails()){
            // return response()->json(['error'=>'Validation Error'], 510);
            return response()->json(  [ 'errdata' => $userdata, 'message' => 'Erreur de Validation'] , 510);
        }


        $userdata['password'] = Hash::make($request->password);

        $user = User::create($userdata);

        $accessToken = $user->createToken('aliauthToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken], 201);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'This User does not exist, check your details'], 400);
        }

        $accessToken = auth()->user()->createToken('aliauthToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

}
