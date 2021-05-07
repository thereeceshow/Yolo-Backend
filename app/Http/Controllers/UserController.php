<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\StockController;  // Do I need this?

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|max:64',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['cash'] = 500000;
        $input['realized_gain'] = 0;
        // $input['stocks'] = []; // CREATE EMPTY ARRAY OF STOCKS

        // Creating new user
        $user = User::create($input);

        /**Take note of this: Your user authentication access token is generated here **/
        $data['token'] =  $user->createToken('YoloFund')->accessToken;
        $data['user_data'] = $user;
        // $data['stocks'] = $user; // SET STOCK ARRAY TO NEW USER

        return response(['data' => $data, 'message' => 'Account created successfully!', 'status' => true]);
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(['success' => 'logout_success'], 200);
        } else {
            return response()->json(['error' => 'api.something_went_wrong'], 500);
        }
    }

    public function login(Request $request)
    {
        Log::debug("login");
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            /**Take note of this: Your user authentication access token is generated here **/
            $data['token'] =  $user->createToken('YoloFund')->accessToken;
            $data['user_data'] = $user;

            return response(['data' => $data, 'message' => 'Account created successfully!', 'status' => true]);
        }
    }
}
