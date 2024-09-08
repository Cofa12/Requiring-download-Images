<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Image;
use App\Models\User;
use App\Notifications\AskForDownloadImage;
use App\Notifications\ConfirmedDownload;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;

class UserController extends Controller
{
    //
    public function getDonwloads($id){
            try{
                $neededImages = Download::where('demander',$id)->where('status','waiting')->get();
                return response()->json([
                    'status' => true,
                    'images'=>$neededImages
                ],200);
            }catch (\Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>'server error',
                    'error'=>$e->getMessage(),
                ],500);
            }
        }
        public function askForDownload(Request $request){
            try{
            $validator = validator::make($request->all(),[
                'image_id'=>'exists:images,id|required',
                'demander_id'=>'exists:users,id|required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()
                ],401);
            }

            $image = Image::findOrFail($request->image_id);
            $downloaded = Download::create([
                'image_id'=>$request->image_id,
                'demander'=>$request->demander_id
            ]);

            $reciever = User::findOrFail($image->publisher);
             $request->image_id;
            if($downloaded){
                $user = $request->User();
                Notification::route('mail',$reciever->email)->notify(new AskForDownloadImage($request->image_id,$image->publisher,$user));
                return response()->json([
                    'status'=>true,
                    'message'=>'the demand is delivered to the publisher successfully'
                ],200);
            }
        } catch (QueryException $e){
            return response()->json([
            'status'=>false,
            'message'=>'We can\'t save the image in the database',
            ],500);
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'server error',
                'error'=>$e->getMessage(),
            ],500);
        }
    }

    public function confirmDownload(Request $request){
          $image_id = Image::where('image_url',$request->get('image_url'))->pluck('id');
          $updatedDonwloadProcess= Download::where('demander',$request->get('demander_id'))->where('image_id',$image_id[0])->update([
            'status'=>'confirmed'
          ]);
          $demanderEmail = User::where('id',$request->get('demander_id'))->pluck('email');
          Notification::route('mail',$demanderEmail[0])->notify(new ConfirmedDownload($image_id[0], $request->get('demander_id')));
        if($updatedDonwloadProcess) {
            return response()->json([
                'status' => true,
                'message' => 'updated Successfully'
            ], 200);
        }

    }

    public function download(Request $request){

        $path = $request->get('image_path');
//        $newName = str_replace('uploadedImages//','',$path);
        return response()->download(storage_path('app/public/'. $path));
    }
}
