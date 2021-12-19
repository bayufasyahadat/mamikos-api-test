<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Room_availability;
use App\Models\Kost;
use App\Models\User;

class TransactionController extends Controller
{
    public function getAvailabilityStatus(Request $request) {
        if (Auth::user()->role != 1) {
            $userid = Auth::id();
            $availability = Room_availability::where('userId', $userid)
                            ->join('kost', 'kost.id', '=', 'room_availability.kostid')
                            ->select('kost.name', 'kost.image','kost.location','kost.price','room_availability.status')
                            ->orderBy('room_availability.created_at', 'desc')
                            ->get();

            return response()->json([
                'success' => true,
                'message' => 'OK',
                'data' => $availability
            ]);
        } else {
            $userid = Auth::id();
            $availability = Room_availability::where('ownerId', $userid)
                            ->join('kost', 'kost.id', '=', 'room_availability.kostid')
                            ->select('kost.name', 'kost.image','kost.location','kost.price','room_availability.status')
                            ->orderBy('room_availability.created_at', 'desc')
                            ->get();

            return response()->json([
                'success' => true,
                'message' => 'OK',
                'data' => $availability
            ]);
        }
    }

    public function askAvailabilityStatus(Request $request, $kostId) {
        $userid = Auth::id();
        $user = User::find($userid);
        if (Auth::user()->role == 1) {
            return response()->json([
                'success' => false,
                'message' => 'You dont have permission',
                'code' => 403 
            ],403);
        } else {
            $kost = Kost::find($kostId);
            if ($kost) {
                $credit = $user->credit;
                if ($credit < 5){
                    return response()->json([
                        'success' => True,
                        'message' => 'Your balance is not enough',
                        'code' => 403 
                    ], 403);
                } else {
                    $cekAvailability = Room_availability::where('userid', $userid)
                                        ->where('kostId', $kostId)
                                        ->get();

                    if (count($cekAvailability) > 0) {
                        return response()->json([
                            'success' => False,
                            'message' => 'Error Failed to send your request, Please Wait until owner Confirm room availability',
                            'code' => 500 
                        ], 500);
                    } else {
                        $availability = Room_availability::create([
                            'kostid' => $kostId,
                            'userid' => $userid,
                            'status' => 'Waiting',
                            'ownerid' => $kost->userId,
                        ]);
    
                        if ($availability) {
                            $credit = $credit - 5;
                            $user->credit = $credit;
                            $user->save();
                            return response()->json([
                                'success' => True,
                                'message' => 'Your request has been sent'
                            ], 202);
                        } else {
                            return response()->json([
                                'success' => False,
                                'message' => 'Error Failed to send your request',
                                'code' => 500 
                            ], 500);
                        }
                    }
                }
            } else {
                return response()->json([
                    'success' => 'Not Found',
                    'message' => 'Data not found'
                ], 404);
            }
        }
    }

}
