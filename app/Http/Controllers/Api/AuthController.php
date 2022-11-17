<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponseTrait;
use App\Models\User;
use Validator;
use JWTAuth;
use App\Classes\ErrorsClass;
class AuthController extends Controller
{

    // using response trait for global format of the reponses
    use ApiResponseTrait;

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->json()->all(), [
                'email' => 'required|string|email',
                'password' => 'required',
            ]);
            if($validator->fails()) {
                return $this->errorResponse($validator->messages(), 422);
            }
            $credentials = $request->only('email', 'password');
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->errorResponse('invalid credentails', 401, 'unauthenticated');
            }
            $user = Auth::user();
            $user->token = $token;        
            return $this->successResponse($user);
        } catch(\Illuminate\Database\QueryException $e) {
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            Log::info($e);
            return $this->sqlResponse();
        } catch(\Exception $e) {
            Log::info($e);
            return $this->undefinedResponse();
        }  
    }

    public function register(Request $request){
        try {
            $validator = Validator::make($request->json()->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required',
            ]);
            if($validator->fails()) {
                return $this->errorResponse($validator->messages(), 400);
            }
            $data = $request->json()->all();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $token = Auth::login($user);
            $user->token = $token;
            return $this->successResponse($user);
        } catch(\Illuminate\Database\QueryException $e) {
            new log();
            $errorClass = new ErrorsClass();
            $errors = $errorClass->saveErrors($e);
            Log::info($e);
            return $this->sqlResponse();
        } catch(\Exception $e) {
            Log::info($e);
            return $this->undefinedResponse();
        }  
    }

   
}
