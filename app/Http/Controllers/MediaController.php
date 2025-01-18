<?php

namespace App\Http\Controllers;

use App\Models\Links;
use App\Models\Supporters;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // Supporters
    public function sShow()
    {
        $supporters=Supporters::orderByDesc('created_at')->get();
        return $supporters;
    }
    public function sStore(Request $request)
    {
            if($request->hasFile('logo')){
                $imagePath=$request->file('logo')->store('images','public');
            }
            Supporters::create([
                'logo'=>$imagePath,
            ]);
            return response('Logo Added',200);

    }
    public function sUpdate(Request $request,$id)
    {
        $supporters=Supporters::find($id);
        if(isset($request->logo)){
            $imagePath=$request->file('logo')->store('images','public');
            if($supporters->logo){
                Storage::disk('public')->delete($supporters->logo);
            }
        }else{
            $imagePath=$supporters->logo;
        }
        $supporters->update([
            'logo'=>$imagePath,
        ]);

        return response('Logo Updated',200);
    }
    public function sDelete($id)
    {
        $supporters=Supporters::find($id);
        if($supporters->logo){
            Storage::disk('public')->delete($supporters->logo);
        }
        $supporters->delete();
        return response('Logo Deleted',200);
    }

    // Videos

    public function vShow()
    {
        $videos=Videos::all();
        return $videos;
    }
    public function vUpdate(Request $request, $id)
{
    $videos = Videos::find($id);

    // Define the video fields to be updated
    $videoFields = ['video1', 'video2', 'video3'];

    foreach ($videoFields as $videoField) {
        if ($request->hasFile($videoField)) {
            // Store the new video file
            $videoPath = $request->file($videoField)->store('videos', 'public');

            // Delete the old video file if it exists
            if ($videos->$videoField) {
                Storage::disk('public')->delete($videos->$videoField);
            }

            // Update the model with the new video path
            $videos->$videoField = $videoPath;
        }
    }

    // Save the updated model
    $videos->save();

    return $request->all();
}

// Links

public function lShow()
{
    $links=Links::all();
    return $links;
}
public function lUpdate(Request $request,$id)
{
    $links=Links::find($id);
    $links->update([
        'facebook'=>$request->facebook,
        'instagram'=>$request->instagram,
        'telegram'=>$request->telegram,
        'x'=>$request->x,
        'linkedin'=>$request->linkedin,
        'youtube'=>$request->youtube,
        'whatsapp'=>$request->whatsapp,
        'address'=>$request->address,
        'phone'=>$request->phone,
        'email'=>$request->email,
    ]);
    return response('Links Updated',200);
}

}
