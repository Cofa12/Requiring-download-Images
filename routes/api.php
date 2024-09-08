<?php

use App\Http\Controllers\auth\AuthController;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ImageController;
use \App\Http\Controllers\UserController;



Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::apiResource('image',ImageController::class);
Route::get('{id}/downloads/',[UserController::class,'getDonwloads']);

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/image/download/',[UserController::class,'askForDownload']);

});

Route::get('/DownloadDetails',function (Request $request){
    $imageId = $request->get('image_id');
    $demander_id = $request->get('demander_id');
    $imagePath = Image::where('id',$imageId)->pluck('image_url')->first();
    return view('emails.confirmEmail',['image_url'=>json_encode($imagePath),'demander_id'=>$demander_id]);
})->name('DownloadDetails');

Route::get('/DownloadConfirm',[UserController::class,'confirmDownload'])->name('confirm');
Route::get('/download',[UserController::class,'download'])->name('download');



