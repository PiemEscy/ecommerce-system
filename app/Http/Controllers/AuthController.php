<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Repositories\RegisterAccountRepository;
use App\Http\Requests\RegisterAccountRequest;

class AuthController extends Controller
{

    public function __construct(RegisterAccountRepository $registerAccountRepo)
    {
        $this->registerAccountRepo = $registerAccountRepo;
    }

    public function register(RegisterAccountRequest $request)
    {
        $data = $request->validated();
        $insert = $this->registerProcess($data);

        return response()->json([
            'success' => $insert,
            'message' => ($insert) ? 'register account successfully!' : 'failed to register account.'
        ], 201);
    }

    public function registerProcess($data)
    {
        return $this->registerAccountRepo->rollBackFunction(function () use ($data) {
            $checkout = $this->registerAccountRepo->createAccount($data);
        }, 'Error creating record');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['success' => false, 'message' => 'Invalid Credentials'], 401);
        }

        return response()->json([
            'success' => true,
            'access_token' => $token
        ], 201);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logged out']);
    }

    public function refresh()
    {
        return response()->json([
            'token' => auth()->refresh()
        ]);
    }
}
