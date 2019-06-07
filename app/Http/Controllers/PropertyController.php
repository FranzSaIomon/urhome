<?php

namespace App\Http\Controllers;

use App\User;
use App\Property;
use App\PropertyAmenity;
use App\Status;
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
        // return $this->get($request);
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

        $or_cols = ["query", 'location', 'type'];

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
                    if (strcasecmp($k, "query") == 0 || strcasecmp($k, "location") == 0)
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
                    } else if (strcasecmp($k, "type") == 0) {
                        foreach($v as $type)
                            array_push($or_condition, ["PropertyTypeID", "=", $type]);
                    }
                        
                    array_push($or_conditions, $or_condition);
                } else if (strcasecmp($k, "purpose") == 0 && in_array($v[0], $purposes)) {
                    array_push($conditions, ['ListingTypeID', '=', $v[0]]);
                }
            }
        }

        $sql = Property::with(['listing_type', 'status', 'user', 'property_amenity', 'property_document', 'property_type'])
            ->where($conditions)->where('StatusID', 1);
        
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

    public function toggleArchive(Request $request, Property $property) {
        if (auth()->user()->id == $property->UserID) {
            if ($property->StatusID == 1)
                $property->StatusID = 2;
            else
                $property->StatusID = 1;

            if ($property->save())
                return response()->json(["message" => ["You've succesfully updated this property"]]);
            else
                return response()->json(["message" => ["Uh Oh! Something went wrong, try again later"]], 422);
        } else
            return response()->json(["message" => ["Oops! Looks like you don't own this property"]], 422);
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
        $request->validate([
            "Name" => "filled",
            "Description" => "filled",
            "Developer" => "filled",
            "LotNo" => "filled",
            "Street" => "filled",
            "City" => "filled",
            "Country" => "filled",
            "YearBuilt" => "filled|integer",
            "FloorArea" => "filled|numeric|min:0",
            "LotArea" => "filled|numeric|min:0",
            "Price" => "filled|numeric|min:0",
            "NumberOfBedrooms" => "filled|integer|min:0",
            "NumberOfBathrooms" => "filled|integer|min:0",
            "CapacityOfGarage" => "filled|integer|min:0",
            "PropertyTypeID" => "exists:property_types,id|integer",
            "ListingTypeID" => "exists:listing_types,id|integer",
            "Amenities.*" => "exists:amenities,id|integer"
        ]);

        $property->Name = $request->Name;
        $property->Description = $request->Description;
        $property->Developer = $request->Developer;
        $property->LotNo = $request->LotNo;
        $property->Street = $request->Street;
        $property->City = $request->City;
        $property->Country = $request->Country;
        $property->YearBuilt = $request->YearBuilt;
        $property->FloorArea = $request->FloorArea;
        $property->LotArea = $request->LotArea;
        $property->Price = $request->Price;
        $property->NumberOfBedrooms = $request->NumberOfBedrooms;
        $property->NumberOfBathrooms = $request->NumberOfBathrooms;
        $property->CapacityOfGarage = $request->CapacityOfGarage;
        $property->ListingTypeID = $request->ListingTypeID;
        $property->PropertyTypeID = $request->PropertyTypeID;
        
        $removed = [];
        $inserted = [];

        if (isset($request->Amenities)) {
            foreach($request->Amenities as $val) {
                $found = false;
                foreach($property->property_amenity as $prop_am) {
                    if ($prop_am->AmenityID == $val)
                        $found = true;
                }
    
                if (!$found)
                    array_push($inserted, $val);
            }

            $n = [];
            foreach($inserted as $insertID) {
                $insert = new PropertyAmenity;
                $insert->PropertyID = $property->id;
                $insert->AmenityID = $insertID;

                $insert->save();
                array_push($n, $insert);
            }
        }
        
        foreach ($property->property_amenity as $prop_am) {
            if (!in_array($prop_am->AmenityID, (isset($request->Amenities) ? $request->Amenities : [])))
            array_push($removed, $prop_am->AmenityID);
        }

        if (count($removed) > 0)
            PropertyAmenity::where('PropertyID', $property->id)
                ->where(function ($q) use ($removed) {
                    foreach ($removed as $remID)
                        $q->orwhere("AmenityID", $remID);
                })
                ->delete();

        $property->save();
        return $removed;
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
        if ($property->StatusID == 2)
            if (!auth()->check() || (auth()->check() && auth()->user()->id != $property->UserID))
                return redirect('/');

        return view('properties.view')->with(['property' => $property, 'title' => $property->Name, 'nolanding' => 'nolanding']);
    }
}
