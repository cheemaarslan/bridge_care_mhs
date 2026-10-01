<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission:read_note'])->only('index');
        $this->middleware(['permission:create_note'])->only('create','store');
        $this->middleware(['permission:update_note'])->only('update','edit');
        $this->middleware(['permission:delete_note'])->only('destroy');

    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $data = $request->validate([
            'care_plan_id' => ['nullable'],
            'monthly_review_id' => ['nullable'],
            'date' => ['required'],
            'note' => ['required', 'string','min:1', 'max:255']
        ]);
        $data['user_id'] = $request->user()->id;
        $note = Note::create($data);

        $note = Note::with('user')->findOrFail($note->id);
        return response($note);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $note = Note::with('user')->findOrFail($id);
        return response($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data =  $request->validate([
            'care_plan_id' => ['nullable'],
            'monthly_review_id' => ['nullable'],
            'date' => ['required'],
            'note' => ['required', 'string','min:1', 'max:255']
        ]);
        $data['user_id'] = auth()->user()->id;
        $note = Note::findOrFail($id);
        $note->update($data);

        $note = Note::with('user')->findOrFail($note->id);

        return response($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return response(200);
    }
}
