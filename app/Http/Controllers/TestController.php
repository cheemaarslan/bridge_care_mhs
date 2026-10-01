<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','permission:crud_test']);
    }
    public function index()
    {
        $tests = Test::all();
        return view('test.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('test.create');

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
            'test_name' => ['required', 'min:1', 'max:255', 'unique:tests'],
            'min_age' => ['nullable'],
            'max_age' => ['nullable'],
            'gender' => ['required'],
            'duration' => ['required', 'min:1', 'max:255'],
            'consent' => ['required']
        ]);
        $data['slug'] = Str::slug($request->screening_name);
        Test::create($data);

        return redirect()->route('test.index')->with('status', 'A new Test has been Added');
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
    public function edit(Test $test)
    {
        return view('test.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        $data = $request->validate([
            'test_name' => ['required', 'min:1', 'max:255', Rule::unique('tests')->ignore($test)],
            'min_age' => ['nullable'],
            'max_age' => ['nullable'],
            'gender' => ['required'],
            'duration' => ['required', 'min:1', 'max:255'],
            'consent' => ['nullable']
        ]);
        $data['slug'] = Str::slug($request->screening_name);

        $test->update($data);

        return redirect()->route('test.index')->with('status', 'Test has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('test.index')->with('status', 'Test has been Removed');
    }
}
