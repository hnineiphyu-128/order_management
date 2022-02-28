<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\GradeResource;
use App\Models\Grade;
use Validator;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $grades = Grade::all();
        $result = GradeResource::collection($grades);
       

        return response()->json($result, 200);
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
        $validator = Validator::make($request->all(),[
            'grade'  => 'required|string|max:255|unique:grades'
        ]);

        if ($validator->fails()) {
            $status = 400;
            $message = 'Validation Error.';

            $response = [
                'status'    =>  $status,
                'success'   =>  false,
                'message'   =>  $message,
                'data'      =>  $validator->errors(),
            ];

            return response()->json($response, 400);
        }
        else{
            $grade_name = $request->grade;

            // Data Insert
            $grade = new Grade();
            $grade->grade = $grade_name;
            $grade->save(); 

            $status = 200;
            $message = 'Grade created successfully.';
            $result = new GradeResource($grade);

            $response = [
                'success'   => true,
                'status'    => $status,
                'message'   => $message,
                'data'      => $result,
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
        $grade = Grade::find($id);

        if (is_null($grade)) {
            # 404
            $status = 404;
            $message = 'Grade not found.';

            $response = [
                'status'    => $status,
                'success'   => false,
                'message'   => $message
            ];

            return response()->json($response,404);
        }else{
            #200
            $status = 200;
            $message = 'Grade retrieved successfully.';
            $result = new GradeResource($grade);

            $response = [
                'status'    =>  $status,
                'success'   =>  true,
                'message'   =>  $message,
                'data'      =>  $result
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
        $grade = Grade::find($id);

        if (is_null($grade)) {

            $status = 404;
            $message = 'Grade not found.';

            $response = [
                'status'  => $status,
                'success' => false,
                'message' => $message,
            ];

            return response()->json($response, 404);

        }
        else{

            $validator = Validator::make($request->all(),[
                'grade'  => 'required|string|max:255|unique:grades'
            ]);

            if ($validator->fails()) {
                $status = 400;
                $message = 'Validation Error.';

                $response = [
                    'status'    =>  $status,
                    'success'   =>  false,
                    'message'   =>  $message,
                    'data'      =>  $validator->errors(),
                ];

                return response()->json($response, 400);
            }
            else{
                $grade_name = $request->grade;
                
                $grade = Grade::find($id);
                // Data update
                
                $grade->grade = $grade_name;
                $grade->save();

                $status = 200;
                $result = new GradeResource($grade);
                $message = 'Grade updated successfully.';

                $response = [
                    'success'   => true,
                    'status'    => $status,
                    'message'   => $message,
                    'data'      => $result
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
        $grade = Grade::find($id);
        if (is_null($grade)) {

            $status = 404;
            $message = 'Grade not found.';

            $response = [
                'status'  => $status,
                'success' => false,
                'message' => $message,
            ];

            return response()->json($response, 404);
        }
        else{

            $grade->delete();

                $status = 200;
                $message = 'Grade deleted successfully.';

                $response = [
                    'success'   =>  true,
                    'status'    =>  $status,
                    'message'   =>  $message
                ];

                return response()->json($response, 200);
        }
    }
}
