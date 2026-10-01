<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReviewQuestion;
use Illuminate\Http\Request;

class MonthlyReviewQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
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
        $question = MonthlyReviewQuestion::findOrFail($id);
        return response($question);
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
        $question = MonthlyReviewQuestion::findOrFail($id);
        $data = $request->validate([
            'question' => ['required', 'string', 'min:3'],
            'option' => ['required', 'array']
        ]);
        $question->update($data);
        return back()->with('status', 'Monthly Review Question has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $question = MonthlyReviewQuestion::findOrFail($id);
        // $question->delete();
        return back()->with('status', 'You cannot remoed these question');

    }
}
