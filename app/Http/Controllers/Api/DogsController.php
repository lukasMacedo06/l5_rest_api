<?php

namespace App\Http\Controllers\Api;

use App\Dog;
use App\DogsTransformer;
use Illuminate\Http\Request;
use App\Traits\ApiORMHelpers;
use App\Http\Controllers\Controller;

class DogsController extends Controller
{
    use ApiORMHelpers;

    public function __construct()
    {
        $this->query = '';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->query = Dog::query();

        $this->filterData($request);

        $this->sortData($request);

        $data = [];
        $data = $this->query->get()->map(function($dog) {
            return (new DogsTransformer($dog))->toArray();
        });

        return response($data)
                ->header('X-Greatness-Index', 9);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Dog::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $embeds = explode(',', $request->get('embed', ''));

        return (new DogsTransformer(Dog::findOrFail($id), $embeds));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $dog = Dog::findOrFail($id);
        $dog->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dog = Dog::findOrFail($id);
        $dog->delete();
    }
}
