<?php

namespace App\Http\Controllers;

use App\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        return $this->get($request)->get();
    }

    public function get(Request $request) {
        $range_cols = [
            'NumberOfBedrooms',
            'NumberOfBathrooms',
            'Price',
            'LotArea',
            'FloorArea'
        ];

        $or_cols = ["query", 'location'];

        $purposes = [1, 2];

        $conditions = [];

        $or_conditions = [];
        foreach ($request->all() as $k => $v) {
            if (isset($v)) {
                if (in_array($k, $range_cols, false)) {
                    if ((strcasecmp($k, "numberofbedrooms") == 0 && $v[1] >= 10) || 
                        (strcasecmp($k, "numberofbathrooms") == 0 && $v[1] >= 10)) {
                        array_push($conditions, [$k, '>=', intval($v[0])]);
                    } else {
                        array_push($conditions, [$k, '>=', intval($v[0])]);
                        array_push($conditions, [$k, '<=', intval($v[1])]);
                    }
                } else if (in_array($k, $or_cols, false)) {
                    $v = explode(' ', preg_replace('/\s+/', ' ', trim($v)));
                    $or_condition = [];

                    if (strcasecmp($k, "query") == 0) {
                        foreach ($v as $term)
                            array_push($or_condition, ["name", 'LIKE', '%' . $term . '%']);
                    } else if (strcasecmp($k, "location") == 0) {
                        foreach ($v as $term) {
                            array_push($or_condition, ["city", 'LIKE', '%' . $term . '%']);
                            array_push($or_condition, ["street", 'LIKE', '%' . $term . '%']);
                        }
                    }
                        
                    array_push($or_conditions, $or_condition);
                } else if (strcasecmp($k, "purpose") == 0 && in_array($v[0], $purposes)) {
                    array_push($conditions, ['ListingTypeID', '=', $v[0]]);
                } else if (strcasecmp($k, "type") == 0 && isset($v)) {
                    array_push($conditions, ['PropertyTypeID', '=', $v]);
                }
            }
        }

        $sql = Property::with(['listing_type', 'status', 'user', 'property_amenity', 'property_document', 'property_type'])
            ->where($conditions);
        
        $sql->where(function($q) use ($or_conditions) {
            foreach($or_conditions as $k)
                for ($i = 0; $i < count($k); $i++)
                    $q->orwhere([$k[$i]]);
        });
        
        // return $sql->toSql();
        return $sql;
    }
    
    public function paginate(Request $request) {
        // return $this->get($request);
        return $this->get($request)->paginate(15);
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
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }

    public function view(Request $request, Property $property) {
        return view('properties.view')->with(['property' => $property, 'title' => $property->Name, 'nolanding' => 'nolanding']);
    }
}
