<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\ProjectImages;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
     // Events--------------------------------------
     public function pShow()
     {
         $projects=Projects::all();
         return $projects;
     }
     public function pidShow($id)
     {
         $projects=Projects::find($id);
         return $projects;
     }
     public function pStore(Request $request)
     {
         $projects=$request->validate([
             'title'=>'required|string',
             'subtitle'=>'required|string',
             'photo1'=>'required|image',
             'photo2'=>'required|image',
             'paragraph1'=>'required',
             'paragraph2'=>'required',
             'paragraph3'=>'required',
             'paragraph4'=>'required',
             'date'=>'required',
         ]);
         if($request->hasFile('photo1')){
             $filePath1=$request->file('photo1')->store('images','public');
         };
         if($request->hasFile('photo2')){
             $filePath2=$request->file('photo2')->store('images','public');
         };

         Projects::create([
             'title'=>$projects['title'],
             'subtitle'=>$projects['subtitle'],
             'paragraph1'=>$projects['paragraph1'],
             'paragraph2'=>$projects['paragraph2'],
             'paragraph3'=>$projects['paragraph3'],
             'paragraph4'=>$projects['paragraph4'],
             'date'=>$projects['date'],
             'photo1'=>$filePath1,
             'photo2'=>$filePath2,
         ]);
         return response('Project Saved',200);
     }
     public function pUpdate(Request $request,$id)
     {
         $projects=Projects::find($id);

         if(isset($request->photo1)){
             $filePath1=$request->file('photo1')->store('images','public');
             if($projects->photo1){
                 Storage::disk('public')->delete($projects->photo1);
             }
         }else{
             $filePath1=$projects->photo1;
         }
         if(isset($request->photo2)){
             $filePath2=$request->file('photo2')->store('images','public');
             if($projects->photo2){
                 Storage::disk('public')->delete($projects->photo2);
             }
         }else{
             $filePath2=$projects->photo2;
         }

         $projects->update([
             'title'=>$request['title'],
             'subtitle'=>$request['subtitle'],
             'paragraph1'=>$request['paragraph1'],
             'paragraph2'=>$request['paragraph2'],
             'paragraph3'=>$request['paragraph3'],
             'paragraph4'=>$request['paragraph4'],
             'date'=>$request['date'],
             'photo1'=>$filePath1,
             'photo2'=>$filePath2,
         ]);

         return response('Project Updated',200);
     }
     public function pDelete($id)
     {
         $projects=Projects::find($id);
         if($projects->photo1){
             Storage::disk('public')->delete($projects->photo1);
         }
         if($projects->photo2){
             Storage::disk('public')->delete($projects->photo2);
         }
         $projects->delete();
         return response("Project Deleted",200);
     }


    //  Project Images

    public function imageShow()
    {
        $images=ProjectImages::all();
        return $images;
    }
    public function imageidShow($id)
    {
        $project=Projects::find($id);
        $images=$project->images;
        return $images;
    }

    public function imageStore(Request $request)
    {
        $image=$request->validate([
            'projectId'=>'required',
            'project'=>'required',
            'photo'=>'required'
        ]);

        if($request->hasFile('photo')){
            $filePath=$request->file('photo')->store('images','public');
        }

        ProjectImages::create([
            'projectId'=>$image['projectId'],
            'project'=>$image['project'],
            'photo'=>$filePath
        ]);

        return response('ProjectImage Saved',200);
    }

    public function imageUpdate(Request $request,$id)
    {
        $image=ProjectImages::find($id);

        if(isset($request->photo)){
            $filePath=$request->file('photo')->store('images','public');
            if($image->photo){
            Storage::disk('public')->delete($request->photo);
            }
        }else{
            $filePath=$image->photo;
        }

        $image->update([
            'projectId'=>$request->projectId,
            'project'=>$request->project,
            'photo'=>$filePath
        ]);

        return response("Updated Done",200);
    }

    public function imageDelete($id)
    {
        $image=ProjectImages::find($id);
        if($image->photo){
            Storage::disk('public')->delete($image->photo);
        }
        $image->delete();
        return response('Delete Done',200);
    }

    // sendEmail----------

    public function sendEmail(Request $request)
    {
        $email=$request->validate([
            'fullName'=>'required|string',
            'subject'=>'required|string',
            'phone'=>'required|string',
            'email'=>'required|email',
            'message'=>'required|string'
        ]);

        Mail::to('la.kpu14@gmail.com')->send(new ContactMessageMail($email));
        return response()->json([
            'message'=>"E-Mail send Successfully",
        ]);
    }

}
