<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $images = Image::all();
            return response()->json([
                'status' => true,
                'images'=>$images
            ],200);
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'server error',
                'error'=>$e->getMessage(),
            ],500);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try{
            $image = $request->file('image');

            $validator = validator::make($request->all(),[
                'image'=>'mimes:jpg,png,jpeg|required',
                'title'=>'string|required',
                'publisher'=>'exists:users,id|required',
                'tags'=>'json'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()
                ],401);
            }


            // to check the magic number
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $image);
            if(!in_array($mimeType,['image/jpg','image/png','image/jpeg'])){
                return response()->json([
                    'status'=>false,
                    'message'=>"this is not a valid image extension"
                ],401);
            }


            // get the content of the file
            $content = File::get($image->getRealPath());
            if(preg_match('<script>',$content)){
                return response()->json([
                    'status'=>false,
                    'message'=>'the file contains a malicious code'
                ],415);
            }

            $path = Storage::disk('public')->putFile('uploadedImages/',$request->file('image'));

            $imageIsCreated = Image::create([
                'image_url'=>$path,
                'title'=>$request->title,
                'publisher'=>$request->publisher,
            ]);

            if($imageIsCreated){
                return response()->json([
                    'status'=>true,
                    'message'=>'Image is created successfully'
                ],200);
            }
        }catch (QueryException $e){
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $image = Image::findOrFail($id);
        return response()->json([
            'status' => true,
            'images'=>$image
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
