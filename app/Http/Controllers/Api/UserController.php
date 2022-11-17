<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use App\Models\User;
use App\Models\Transaction;
use App\Traits\ApiResponseTrait;
use App\Classes\ErrorsClass;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponseTrait;
    
    public function addMoneyToWallet(Request $request){
        try {
            $validator = Validator::make($request->json()->all(), [
                'amount' => 'required',
            ]);
            if($validator->fails()) {
                return $this->errorResponse($validator->messages(), 400);
            }
            $data = $request->json()->all();
            $header = $request->header('Authorization');
            $userId = $this->jwtTokenDecodeResponse($header);
            $userDetail = User::find($userId);
            if($userDetail){
                if($data['amount']>=3 && $data['amount']<=100){
                    $userDetail->wallet = $userDetail->wallet+$data['amount'];
                    $userDetail->save();
                    if($userDetail){
                        $transaction = new Transaction();
                        $transaction->user_id = $userId;
                        $transaction->wallet  =  $data['amount'];
                        $transaction->type    = 'credit';
                        $transaction->save();
                    }
                    return $this->successResponse($userDetail);
                }else{
                    return $this->errorResponse('Something went wrong', 400, 'Amount add minimum 3$ and maximum 100$');
                }
            }else{
                return $this->errorResponse('Something went wrong', 400, 'user not found over system');
            }
        
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

    public function buyCookie(Request $request){
        try {
            $validator = Validator::make($request->json()->all(), [
                'cookie_quntity' => 'required',
            ]);
            if($validator->fails()) {
                return $this->errorResponse($validator->messages(), 400);
            }
            $data = $request->json()->all();
            $header = $request->header('Authorization');
            $userId = $this->jwtTokenDecodeResponse($header);
            $userDetail = User::find($userId);
            if($userDetail){
                if($data['cookie_quntity'] < 1 || $data['cookie_quntity'] > 10){
                    return $this->errorResponse('Something went wrong', 400, 'Cookie quntity buy mimimum 1$ and maximum 10$');
                }
                if($userDetail->wallet >= $data['cookie_quntity']){
                    $userDetail->wallet = $userDetail->wallet-$data['cookie_quntity'];
                    $userDetail->save();
                    if($userDetail){
                        $transactionDetail = new Transaction;
                        $transactionDetail->user_id = $userId;
                        $transactionDetail->wallet  =  $data['cookie_quntity'];
                        $transactionDetail->type    = "debit";
                        $transactionDetail->save();
                    }
                    return $this->successResponse($userDetail);
                }else{
                    return $this->errorResponse('Something went wrong', 400, 'Insufficient Balance');
                }
            }else{
                return $this->errorResponse('Something went wrong', 400, 'user not found over system');
            }
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
    

}
