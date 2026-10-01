<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\MonthlyReviewScheme;

class MonthlyReviewSchemeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:crud_monthly_review_scheme');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schemes = MonthlyReviewScheme::all();
        return view('monthly-review.scheme.index', compact('schemes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('monthly-review.scheme.create');

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
            'scheme_name' => ['required', 'string', 'min:5', 'max:255', 'unique:monthly_review_schemes']
        ]);
        MonthlyReviewScheme::create($data);    
        return redirect()->route('monthly-review-scheme.index')->with('status', 'Monthly Review Scheme has been created');

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
    public function edit(MonthlyReviewScheme $monthly_review_scheme)
    {
        return view('monthly-review.scheme.edit', compact('monthly_review_scheme'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonthlyReviewScheme $monthly_review_scheme)
    {
        $data = $request->validate([
            'scheme_name' => ['required', 'string', 'min:5', 'max:255', Rule::unique('monthly_review_schemes')->ignore($monthly_review_scheme)]
        ]);
        $monthly_review_scheme->update($data);
        return redirect()->route('monthly-review-scheme.index')->with('status', 'Monthly Review Scheme has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
