<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/',
            'role' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' =>$validator->errors()
            ]);       
        } else {

            // Credit Value
            $credit = null;
            switch ($request->role) {
                case 2:
                    // Role UserReguler get 20 credit
                    $credit = 20;
                    break;

                case 3:
                    // Role User Premium get 40 credit
                    $credit = 40;
                    break;
    
                default:
                    // Role Owner get 0 credit
                    $credit = 0;
                    break;
            }

            //Checking Role Correct
            $roleCheck = Role::select('roles.name')
                        ->where('roles.id', '=', $request->role)
                        ->get();

            if (count($roleCheck) < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please Enter Valid Role !'
                ]);
            } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'credit' => $credit
                ]);
            }
            

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User Register success',
                'access_token' => $token, 
                'token_type' => 'Bearer', 
            ]);
        }
    }

    // Login
}
