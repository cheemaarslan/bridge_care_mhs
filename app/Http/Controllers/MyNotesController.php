<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\MyNotes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MyNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user(); // Get the authenticated user
        $my_notes = MyNotes::where('user_id', $user->id)->get();
        return view('my-notes.index', compact('my_notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'nullable',
            'date' => 'nullable',
            'patient_note' => 'nullable',
        ]);
    
        // Assuming 'date' is formatted as 'Y-m-d H:i:s', you can convert it to Carbon instance.
        // $date = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('date'));
        $slug = Carbon::now()->timestamp;
     
        $user = auth()->user(); 
        $myNote = MyNotes::create([
            'user_id' => $user->id,
            'patient_id' => $request->input('patient_id'),
            'note' => $request->input('patient_note'),
            'date' => $request->input('date'),
            'slug' => $slug, 
        ]);
    
        // You may want to return a JSON response with the saved data.
        return response($myNote);
        }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MyNotes $my_notes)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $my_notes = MyNotes::findOrFail($id);
        return response($my_notes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyNotes $my_notes)
    {
        $validatedData = $request->validate([
            'note' => 'required|string',
            'date' => 'required',
        ]);
        
        $note_id = $request->note_id;
    
        $my_notes = MyNotes::where('id', $note_id)->update([
            'note' => $validatedData['note'],
            'date' => $validatedData['date'],
        ]);
    
        // Retrieve the updated record if needed
        $updatedNote = MyNotes::find($note_id);
        return response()->json([
            'message' => 'Update successful',
            'id' => $updatedNote->id, // Include the ID in the response
            'date' => $updatedNote->date,
            'note' => $updatedNote->note,
        ]);
        
    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $my_notes = MyNotes::findOrFail($id);
            $my_notes->delete();
    
            return response()->json(['message' => 'Data has been removed'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        }
    }
    
}
