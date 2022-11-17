<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;
trait ApiResponseTrait {

    // error response would have same format across the project, parameters can be changed accordingly
    public function errorResponse($error = null, $code = 404, $message = 'Some error has been occurred', $status = false, $data = []) {
        return response()->json([
            'message'  => $error,
            'status' => $status,
            'error' => $message,
            'data'    => $data
        ], $code);
    }
    
    // success response would have same format across the project, parameters can be changed accordingly
    public function successResponse($data = [], $code = Response::HTTP_OK, $status = true, $message = 'Record found successfully') {
        return response()->json([
            'error'  => '',
            'status' => $status,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public function sqlResponse($data = [], $code = 500, $status = false, $message = 'Sql Query Error') {
        return response()->json([
            'error'  => '',
            'status' => $status,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public function undefinedResponse($data = [], $code = 500, $status = false, $message = 'Undefined Variable Error') {
        return response()->json([
            'error'  => '',
            'status' => $status,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    // public function jwtTokenDecodeResponse($header){
    //     $convertStringToArray =  explode(" ",$header);
    //     $token =$convertStringToArray[1];
    //     $tokenDetail = JWTAuth::getPayload($token)->toArray();
    //     return $userId = $tokenDetail['sub'];
    // }
}