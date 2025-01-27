<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Throwable;
use Validator;
use App\Models\User;

class UserController extends Controller
{

    public function index(){

    }

    public function createUser (Request $request){
        try {

            $validateUser = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json(['status' => false, 
                'message' => 'Validation Error',
                'errors' => $validateUser->errors()
                ], 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return response()->json(
                ['message' => 'User created successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken],200
            );
        }
        catch(Throwable $e){
            return response()->json(['message' => 'User creation failed'], 500);
        }

    }

    public function loginUser(Request $request){
        try {
            $validateUser = Validator::make($request->all(),[
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json(['message' => 'Validation Error'], 401);
            }

            if(!Auth::attempt($request->all())){
                return response()->json(['message' => 'Email and Password does not match our record'], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json(
                ['message' => 'User login successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken], 200);


        }catch(Throwable $e){
            return response()->json(['message' => 'User login failed'], 500); 

        }
    }
}
