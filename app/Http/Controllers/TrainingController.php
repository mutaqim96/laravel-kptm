<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use File;
use Storage;
use App\Http\Requests\StoreTrainingRequest;
use Mail;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {   
        if($request->keyword){
                $search = $request->keyword;
                
                //Kalau nak display semua daripada table user.
                // $trainings = Training::where('title','LIKE','%'.$search.'%')
                // ->orWhere('description','LIKE','%'.$search.'%')
                // ->paginate(5);

                //Kalau only untuk user punya training. Orang lain punya training dia takmau tau.
                $trainings = auth()->user()->trainings()->where('title','LIKE','%'.$search.'%')
                ->orWhere('description','LIKE','%'.$search.'%')
                ->orderBy('created_at','desc')
                ->paginate(5);

        }else{            
                // query trainings from trainings table using model
                //$trainings = Training::paginate(5);
                
                //get current autenticated user.
                $user =auth()->user();

                //get user's trainig using relationship(trainings) with pagination by 5 item per page
                $trainings = $user->trainings()->paginate(5);      
            }



        // dd($trainings); // dump and die

        // return to view with $trainings
        // resources/views/trainings/index.blade.php
        return view('trainings.index', compact('trainings'));

    }

    public function create()
    {
        // return training create form
        // resources/views/trainings/create.blade.php
        return view('trainings.create');
    }

    public function store(StoreTrainingRequest $request)
    {   
        // $this->validate(
        //     $request,
        //     [
        //         'title'=>'required|min:10',
        //         'description' => 'required|min:5',
        //         'attachment' =>  'mimes:jpg,pdf',
        //     ]
        //     );

        // store all data from form to trainings table
        // dd($request->all());

        //Method 1 - POPO - Plain Old PHP Object boleh tukar jadi mass assignmenr
        $training = new Training();
        $training->title = $request->title;
        $training->description = $request->description;
        $training->trainer = $request->trainer;
        $training->user_id = auth()->user()->id;
        $training->save();

        if($request->hasFile('attachment'))
        {
            //tukar nama file. supaya x redundant. kata2 xmau
            //idnum-yyyy-mm-dd.jpg
            $filename = $training->id.'-'.date("Y-m-d").'.'.$request->attachment->getClientOriginalExtension();
            

            //simpan file kat storage, sebab kita tak letak dalam database.
            Storage::disk('public')->put($filename, File::get($request->attachment));

            //update row dengan filename.
            $training->update(['attachment'=>$filename]);

        }

        //send email to user
        Mail::send('email.training-created',[], function($message){
            $message->to('mutaqim96@gmail.com');
            $message->subject('Training Created Email using Inline ');
        });

        // return redirect back
        return redirect()
            ->route('training:list')
            ->with([
                'alert-type' => 'alert-primary',
                'alert' => 'Your training has been created!'
            ]);
    }

    public function show(Training $training)
    {
        // return to view
        return view('trainings.show', compact('training'));
    }

    public function edit(Training $training)
    {
        // return to view
        return view('trainings.edit', compact('training'));
    }

    public function update(Training $training, Request $request)
    {
        // update training with edited attributes
        // Method 2 - Mass Assignment
        $training->update($request->only('title', 'description', 'trainer'));

        // return to /trainings
        return redirect()
            ->route('training:list')
            ->with([
                'alert-type' => 'alert-success',
                'alert' => 'Your training has been updated!'
            ]);
    }

    public function delete(Training $training)
    {
        if($training->attachment){
            Storage::disk('public')->delete($training->attachment);
        }
        $training->delete();

        return redirect()
            ->route('training:list')
            ->with([
                'alert-type' => 'alert-danger',
                'alert' => 'Your training has been deleted.'
            ]);
    }
}
