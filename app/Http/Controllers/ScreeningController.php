<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScreeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','permission:crud_screening']);
    }

    public function index()
    {
        $screenings = Screening::all();
        return view('screening.index', compact('screenings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('screening.create');
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
            'screening_name' => ['required', 'min:1', 'max:255', 'unique:screenings'],
            'min_age' => ['nullable'],
            'max_age' => ['nullable'],
            'gender' => ['required'],
            'duration' => ['required', 'min:1', 'max:255'],
            'consent' => ['nullable']
        ]);
        $data['slug'] = Str::slug($request->screening_name);
        Screening::create($data);

        return redirect()->route('screening.index')->with('status', 'A new Screening has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Screening $screening)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Screening $screening)
    {
        return view('screening.edit', compact('screening'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Screening $screening)
    {
        $data = $request->validate([
            'screening_name' => ['required', 'min:1', 'max:255', Rule::unique('screenings')->ignore($screening)],
            'min_age' => ['nullable'],
            'max_age' => ['nullable'],
            'gender' => ['required'],
            'duration' => ['required', 'min:1', 'max:255'],
            'consent' => ['nullable']
        ]);
        $data['slug'] = Str::slug($request->screening_name);
        $screening->update($data);

        return redirect()->route('screening.index')->with('status', 'Screening has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Screening $screening)
    {
        $screening->delete();
        return redirect()->route('screening.index')->with('status', 'Screening has been removed');

    }
}
