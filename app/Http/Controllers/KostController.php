<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Kost;


class KostController extends Controller
{
    //Create Kost
    public function createKost(Request $request) {
        if (Auth::user()->role != 1) {
            return response()->json([
                'status' => 'Access forbidden',
                'message' => 'You dont have permission',
                'code' => 403 
            ],403);
        } else {
            
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'image' => 'required|image:jpeg,png,jpg|max:2048',
                'description' => 'required',
                'location' => 'required',
                'price' => 'required'
            ]);
       
            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors(),
                    'code' => 400 
                ]);
            }

            $uploadFolder = 'kost';
            $image = $request->file('image');
            $imageUploaded = $image->store($uploadFolder, 'public');
            $imagePath = '/storage/'.$imageUploaded;
    
            $userId = Auth::id();

            $kost = Kost::create([
                'userId' => $userId,
                'image' => $imagePath,
                'name' => $request->name,
                'location' => $request->location,
                'price' => $request->price,
                'description' => $request->description
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Create success',
                'data' => $kost
            ]);
        }
    }

    //Update Kost
    public function updateKost(Request $request, $id) {
        if (Auth::user()->role != 1) {
            return response()->json([
                'status' => 'Access forbidden',
                'message' => 'You dont have permission',
                'code' => 403 
            ],403);
        } else {
            $userId = Auth::id();
            $kost = Kost::find($id);
            if ($kost) {
                if ($kost->userId == $userId ) {
                    if ($request->name != NULL) {
                        $kost->name = $request->name;
                    }
                    if ($request->location != NULL) {
                        $kost->location = $request->location;
                    }
                    if ($request->description != NULL) {
                        $kost->description = $request->description;
                    }
                    if ($request->price != NULL) {
                        $kost->price = $request->price;
                    }
                    if ($request->file('image') != NULL) {
                        $validator = Validator::make($request->all(),[
                            'image' => 'required|image:jpeg,png,jpg|max:2048'
                        ]);
                   
                        if($validator->fails()){
                            return response()->json([
                                'success' => false,
                                'message' => $validator->errors(),
                                'code' => 400 
                            ],400);
                        } else {
                            $uploadFolder = 'kost';
                            $image = $request->file('image');
                            $imageUploaded = $image->store($uploadFolder, 'public');
                            $imagePath = '/storage/'.$imageUploaded;
                            $kost->image = $imagePath;
                        }
                        
                    }
                    $kost->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Update success',
                        'data' => $kost
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'status' => 'Access forbidden',
                        'message' => 'You dont have permission',
                        'code' => 403 
                    ],403);
                }       
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Not Found'
                ],404);
            }
        }
    }

    //Delete Kost
    public function deleteKost(Request $request, $id) {
        if ($request->user()['role'] != 1) {
            return response()->json([
                'status' => false,
                'message' => 'You dont have permission',
                'code' => 403 
            ],403);
        } else {
            $kost = Kost::find($id);
            if ($kost) {
                $kost->destroy($id);
                return response()->json([
                    'success' => true,
                    'message' => 'delete success',
                    'code' => 200 
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Not Found'
                ],404);
            }
        }
    }

    //Detail for Owner Kost
    public function getKostbyIdOwner() {
        if (Auth::user()->role != 1) {
            return response()->json([
                'status' => 'Access forbidden',
                'message' => 'You dont have permission',
                'code' => 403 
            ]);
        } else {
            $userid = Auth::id();
            $kost = Kost::where('userid', $userid)->get();
            return response()->json([
                'success' => true,
                'message' => 'OK',
                'data' => $kost
            ]);
        }
    }

    //detail kost for all user
    public function detailKost($id) {
        return response()->json([
            'success' => true,
            'message' => 'OK',
            'data' => Kost::find($id)
        ]);
    }

    //all kost list
    public function index() {
        return response()->json([
            'success' => true,
            'message' => 'OK',
            'data' => Kost::all()
        ]);
    }
}
