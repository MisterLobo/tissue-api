<?php

namespace App\Services\Api\Http\Controllers;

use App\Services\Api\Features\SocialLoginFeature;
use App\Services\Api\Features\UserAuthFeature;
use Framework\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Lucid\Foundation\Http\Controller;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function index(Request $request)
    {
        /*$request->validate([
            'name' => 'required_without:email|min:2',
            'user_token' => 'required'
        ]);
        $email = $request->email;
        if (Auth::guard('web')->attempt(['email' => $email, 'password' => $request->user_token])) {
            $user = Auth::user();
            $tokenResult = $user->createToken('accessToken')->plainTextToken;
            return response(['success' => true, 'message' => 'login successful', 'access_token' => $tokenResult], 200);
        } else {
            return response(['success' => false, 'message' => 'Invalid credentials'], 404);
        }*/
        return $this->serve(UserAuthFeature::class);
    }

    public function SocialSignup($provider)
    {
        // Socialite will pick response data automatic
        return $this->serve(SocialLoginFeature::class, ['name' => $provider]);
    }

    public function getUserFromSession(Request $request, $provider)
    {
        try {
            $token = $request->input('token');
            $user = Socialite::driver($provider)->userFromToken($token);

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
