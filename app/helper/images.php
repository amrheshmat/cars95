<?php 

use Illuminate\Support\Facades\Storage;

function uploadOneImage($doc,$sub_folder,$id)
{
   
    $dt = now();
    $uploadedFile = $doc;
    $filename = time().$uploadedFile->getClientOriginalName();
    $doc->storeAs('public/upload/'.$sub_folder.'/'.$id.'/', $filename);

    return 'public/upload/'.$sub_folder.'/'.$id.'/'.$filename;

    // // return $filename;
    // if(File::exists(public_path('/upload/'.$sub_folder.'/'.$id)) == false ){File::makeDirectory(public_path('/upload/MedicalRequests/'.$id,0777,true));}
    // // img
    // $uploadedFile = $doc;
    // $filename = time().$uploadedFile->getClientOriginalName();
    // $doc->storeAs('/upload/'.$sub_folder.'/'.$id.'/', $filename);

    // $picture = Image::make($base);
    // $picture->resize(600, null, function ($constraint) {$constraint->aspectRatio();});
    // $picture->save(public_path().'/upload/'.$sub_folder.'/'.$id.'/MedicalRequests.jpg',50);
    // return  '/upload/'.$sub_folder.'/'.$id.'/'.$filename;
                        
}

function uploadRequestImage($doc,$sub_folder)
{
    
    $dt = now();
    $uploadedFile = $doc;
    $filename = time().$uploadedFile->getClientOriginalName();
    $doc->storeAs('public/files/'.$sub_folder.'/', $filename);

    return $filename;
                        
}