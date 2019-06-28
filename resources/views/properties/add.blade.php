@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="vue-listing-add">
        <div class="row" v-if="success">
            <div class="col-md-12">
                <div class="alert alert-success" v-html="success"></div>
            </div>
        </div>
        <div class="row mb-2 mt-3">
            <h2 class="col-md-12 font-weight-bold">
                Property Photos
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input-group :errors="errors" id="PropertyImages" name="PropertyImages" label="Property Images" type="image" placeholder="Choose Files" multiple></input-group>
            </div>
            
        </div>
        <div class="row mb-2 mt-4">
            <h2 class="col-md-12 font-weight-bold">
                Listing Details
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <input-group :values="values" :errors="errors" name="Name" label="Property Name" placeholder="Property Name"></input-group>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input-group :values="values" :errors="errors" name="Developer" label="Property Developer" placeholder="Property Developer"></input-group>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input-group type="multitext" :values="values" :errors="errors" name="Description" label="Description" placeholder="Post Description"></input-group>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Address</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input-group :errors="errors" :values="values" name="LotNo" id="lotNo" placeholder="Lot #"></input-group>
                            </div>
                            <div class="col-md-6">
                                <input-group :errors="errors" :values="values" name="Street" id="street" placeholder="Street"></input-group>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input-group type="text" :errors="errors" :values="values" name="City" type="city" id="city" placeholder="City" required></input-group>
                            </div>
                            <div class="col-md-6">
                                <input-group :errors="errors" :values="values" :countries="countries" name="Country" type="country" id="country" placeholder="-- Country --" required></input-group>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <input-group type="select" :options="property_types" :values="values" :errors="errors" name="PropertyTypeID" label="Property Type" id="property_type" placeholder="-- Select Property Type --" required></input-group>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input-group type="select" :options="listing_types" :values="values" :errors="errors" name="ListingTypeID" label="Listing Type" id="listing_type" placeholder="-- Select Listing Type --" required></input-group>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input-group type="text" :errors="errors" :values="values" label="Price (&#8369;)" name="Price" id="price" placeholder="Price" required></input-group>
                    </div>
                    <div class="col-md-6">
                        <input-group type="select" :options="years" :values="values" :errors="errors" name="YearBuilt" label="Year Built" placeholder="Year Built"></input-group>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input-group :values="values" :errors="errors" name="FloorArea" label="Floor Area (sqm.)" placeholder="Floor Area (in sqm.)"></input-group>
                    </div>  
                    <div class="col-md-6">
                        <input-group :values="values" :errors="errors" name="LotArea" label="Lot Area (sqm.)" placeholder="Lot Area (in sqm.)"></input-group>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input-group :values="values" :errors="errors" name="NumberOfBedrooms" label="# of Bedrooms" placeholder="# of Bedrooms"></input-group>
                    </div>
                    <div class="col-md-6">
                        <input-group :values="values" :errors="errors" name="NumberOfBathrooms" label="# of Bathrooms" placeholder="# of Bathrooms"></input-group>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input-group :values="values" :errors="errors" name="CapacityOfGarage" label="Garage Capacity" placeholder="# of Cars"></input-group>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <multi-select :Values="values" :errors="errors" :options="options" name="Amenities" label="Amenities"></multi-select>
            </div>
        </div>
    </div>
@endsection