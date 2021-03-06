<?php

namespace App\Http\Controllers;

use App\Market;
use Illuminate\Http\Request;
use App\Farm;
class Marketcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $markets = Market::orderBy('name','asc')->paginate(5);
        return view('markets.index', ['markets' => $markets]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('markets.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request,[
            'name' => 'bail|required|unique:markets|max:255',
            'website' => 'bail|required|url',
            'city' => 'bail|required',           
        ]);
        Market::create($request->all());
        return redirect('markets');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function show(Market $market)
    {
        return view('markets.show', ['market' => $market]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function edit(Market $market)
    {
        $farms = Farm::get()->pluck('name', 'id')->sortBy('name');
        return view('markets.edit', compact('market', 'farms'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Market $market)
    {
        $market->update($request->all());
        $market->farms()->sync($request->farms);
        return view('markets.show', ['market' => $market]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function destroy(Market $market)
    {
        //
    }
}
