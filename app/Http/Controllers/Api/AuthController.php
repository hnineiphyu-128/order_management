<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use Validator;
class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'    	=> 'required',
            'password' 	=> 'required',
        ]);

        if($validator->fails()){
            $message = 'Validation Error.';
            $status = 400;

            $response = [
                'status'  => $status,
                'success' => false,
                'data'    => $validator->errors(),
                'message' => $message,
            ];

            return response()->json($response, 400);       
        }
        else{
            $phone = $request->phone;
            $password = $request->password;


             // authentication attempt
            if (auth()->attempt(['phone' => $phone, 'password' => $password])) {
            
            
                $user = Auth::user();
                $token = auth()->user()->createToken('MyApp')->accessToken;
                // $token = $tokenResult->token;

                $message = 'User login successfully.';
                $status = 200;
                $result = new UserResource($user);

                $response = [
                    'status'  => $status,
                    'success' => true,
                    'data'    => $result,
                    'token'	  => $token,
                    'token_type' => 'Bearer',
                    'message' => $message,
                ];
                // return response()->json(Auth::hasUser());
                
                return response()->json($response, 200);
            } 
            else{ 

                $message = 'Phone number or Password invalid!!';
                $status = 401;

                $response = [
                    'status'  => $status,
                    'success' => false,
                    'message' => $message,
                ];

                return response()->json($response, 401);
            } 
        }
    }

    public function logout(){
        $access_token = auth()->user()->token();

        // logout from only current device
        $tokenRepository = app(TokenRepository::class);
        $tokenRepository->revokeAccessToken($access_token->id);
        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 200);
    	// if (Auth::check()) {
            
	    //    Auth::user()->AuthAcessToken()->delete();

	    //    	return response()->json([
	    //         'message' => 'Successfully logged out'
	    //     ]);
	    // }else{ 

        // 	$message = 'User does not login yet!!';
	    //     $status = 400;

	    //     $response = [
	    //         'status'  => $status,
	    //         'success' => false,
	    //         'message' => $message,
	    //     ];

        //     return response()->json($response, 400);
        // } 
    }
        
}
