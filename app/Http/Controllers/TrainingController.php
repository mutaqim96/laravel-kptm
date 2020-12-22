<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use File;
use Storage;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // query trainings from trainings table using model
        //$trainings = Training::paginate(5);
        
        //get current autenticated user.
        $user =auth()->user();

        //get user's trainig using relationship(trainings) with pagination by 5 item per page
        $trainings = $user->trainings()->paginate(5);

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

    public function store(Request $request)
    {   
        $this->validate(
            $request,
            [
                'title'=>'required|min:10',
                'description' => 'required|min:5',
            ]
            );

        // store all data from form to trainings table
        // dd($request->all());

        //Method 1 - POPO - Plain Old PHP Object
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
