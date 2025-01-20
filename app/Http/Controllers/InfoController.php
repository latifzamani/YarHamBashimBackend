<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Events;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    // Team Members
    public function mShow()
    {
        $members=Members::all();
        return $members;
    }
    public function mStore(Request $request)
    {
        $members=$request->validate([
            'fullName'=>'required|string',
            'position'=>'required|string',
            'photo'=>'required|image',
            'facebook'=>'nullable',
            'instagram'=>'nullable',
            'x'=>'nullable',
        ]);
        if($request->hasFile('photo')){
            $filePath=$request->file('photo')->store('images','public');
        };

        Members::create([
            'fullName'=>$members['fullName'],
            'position'=>$members['position'],
            'facebook'=>$members['facebook'],
            'instagram'=>$members['instagram'],
            'x'=>$members['x'],
            'photo'=>$filePath,
        ]);
        return response('Member Saved',200);
    }
    public function mUpdate(Request $request,$id)
    {
        $members=Members::find($id);
        if(isset($request->photo)){
            $filePath=$request->file('photo')->store('images','public');
            if($members->photo){
                Storage::disk('public')->delete($members->photo);
            }
        }else{
            $filePath=$members->photo;
        }

        $members->update([
            'fullName'=>$request->fullName,
            'position'=>$request->position,
            'facebook'=>$request->facebook,
            'instagram'=>$request->instagram,
            'x'=>$request->x,
            'photo'=>$filePath,
        ]);

        return response('Member Updated',200);
    }
    public function mDelete($id)
    {
        $members=Members::find($id);
        if($members->photo){
            Storage::disk('public')->delete($members->photo);
        }
        $members->delete();
        return response("Member Deleted",200);
    }

    // Events--------------------------------------
    public function eShow()
    {
        $events=Events::all();
        return $events;
    }
    public function eidShow($id)
    {
        $events=Events::find($id);
        return $events;
    }
    public function eStore(Request $request)
    {
        $events=$request->validate([
            'title'=>'required|string',
            'description'=>'required|string',
            'photo'=>'required|image',
            'address'=>'required',
            'date'=>'required',
            'time'=>'required',
        ]);
        if($request->hasFile('photo')){
            $filePath=$request->file('photo')->store('images','public');
        };

        Events::create([
            'title'=>$events['title'],
            'description'=>$events['description'],
            'address'=>$events['address'],
            'date'=>$events['date'],
            'time'=>$events['time'],
            'photo'=>$filePath,
        ]);
        return response('Event Saved',200);
    }
    public function eUpdate(Request $request,$id)
    {
        $events=Events::find($id);
        if(isset($request->photo)){
            $filePath=$request->file('photo')->store('images','public');
            if($events->photo){
                Storage::disk('public')->delete($events->photo);
            }
        }else{
            $filePath=$events->photo;
        }

        $events->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'address'=>$request->address,
            'date'=>$request->date,
            'time'=>$request->time,
            'photo'=>$filePath,
        ]);

        return response('Event Updated',200);
    }
    public function eDelete($id)
    {
        $events=Events::find($id);
        if($events->photo){
            Storage::disk('public')->delete($events->photo);
        }
        $events->delete();
        return response("Event Deleted",200);
    }


    // Chart--------------------------------------

    public function cShow()
    {
        $chart=Chart::all();
        return $chart;
    }
    public function cStore(Request $request)
    {
        $chart=$request->validate([
            'value'=>'required|string',
            'label'=>'required|string',
        ]);

        Chart::create([
            'value'=>$chart['value'],
            'label'=>$chart['label'],
        ]);
        return response('Percentage Saved',200);
    }
    public function cUpdate(Request $request,$id)
    {
        $chart=Chart::find($id);
        $chart->update([
            'value'=>$request->value,
            'label'=>$request->label,
        ]);

        return response('Percentage Updated',200);
    }
    public function cDelete($id)
    {
        $chart=Chart::find($id);
        $chart->delete();
        return response("Percentage Deleted",200);
    }
}
