<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        $result = UserResource::collection($users);
        $message = 'Users retrieved successfully.';
        $status = 200;

        $response = [
            'status'  => $status,
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];

        return response()->json($response, 200);
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
        $validator = Validator::make($request->all(), [
            'name' 		=> 'required',
            'phone'    	=> 'required',
            'email' 	=> 'required|email|unique:users',
            'password' 	=> 'required',
            'grade_id' 	=> 'required|numeric|min:0|not_in:0'
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
            $name = $request->name;
            $email = $request->email;
            $phone = $request->phone;
            $password = $request->password;
            $shop_name = $request->shop_name;
            $address = $request->address;
            $grade_id = $request->grade_id;

            $user = User::create([
                'name'      =>  $name,
                'email'     =>  $email,
                'phone'     =>  $phone,
                'password'  =>  Hash::make($password),
                'shop_name' => $shop_name,
                'address'   =>  $address,
                'grade_id'   =>  $grade_id,
            ]);
            $user->assignRole('end_user');
            // Auth::login($user);
            // $token = $user->createToken('MyApp')->accessToken;

            $message = 'User created successfully.';
            $status = 200;
            $result = new UserResource($user);

            $response = [
                'status'  => $status,
                'success' => true,
                'data'    => $result,
                // 'token'	  => $token,
                'message' => $message,
            ];


            return response()->json($response, 200);
        }
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
        $user = User::find($id);

        if (is_null($user)) {

            $status = 404;
            $message = 'User not found.';

            $response = [
                'status'  => $status,
                'success' => false,
                'message' => $message,
            ];

            return response()->json($response, 404);

        }
        else{
            $status = 200;
            $result = new UserResource($user);
            $message = 'User retrieved successfully.';

            $response = [
                'status'  => $status,
                'success' => true,
                'message' => $message,
                'data'    => $result,
            ];


            return response()->json($response, 200);

        }
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
        $user = User::find($id);

        if (is_null($user)) {

            $status = 404;
            $message = 'User not found.';

            $response = [
                'status'  => $status,
                'success' => false,
                'message' => $message,
            ];

            return response()->json($response, 404);

        }
        else{
            $validator = Validator::make($request->all(), [
                'name' 		=> 'required',
                'phone'    	=> 'required',
                'email' 	=> 'required|email',
                'password' 	=> 'required',
                'grade_id' 	=> 'required|numeric|min:0|not_in:0'
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
                $name = $request->name;
                $email = $request->email;
                $phone = $request->phone;
                $password = $request->password;
                $shop_name = $request->shop_name;
                $address = $request->address;
                $grade_id = $request->grade_id;

                $user = User::find($id);
                // Data update
                $user->name = $name;
                $user->email = $email;
                $user->phone = $phone;
                $user->password = $password;
                $user->shop_name = $shop_name;
                $user->address = $address;
                $user->grade_id = $grade_id;
                $user->save();

                // Auth::login($user);
                // $token = $user->createToken('MyApp')->accessToken;

                $message = 'User updated successfully.';
                $status = 200;
                $result = new UserResource($user);

                $response = [
                    'status'  => $status,
                    'success' => true,
                    'data'    => $result,
                    // 'token'	  => $token,
                    'message' => $message,
                ];


                return response()->json($response, 200);
            }
        }
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
        $user = User::find($id);

        if (is_null($user)) {

            $status = 400;
            $message = 'User not found.';

            $response = [
                'status'  => $status,
                'success' => false,
                'message' => $message,
            ];

            return response()->json($response, 404);
        }
        else{

            $user->delete();

            $status = 200;
            $message = 'User deleted successfully.';

            $response = [
                'status'  => $status,
                'success' => true,
                'message' => $message,
            ];


            return response()->json($response, 200);
        }
    }
}
