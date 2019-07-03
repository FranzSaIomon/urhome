@extends('layouts.app')

@section('content')
    <form class="container-fluid w-75" id="vue-listing-add" @submit.prevent="post">
        @csrf
        <div class="row" v-if="info">
            <div class="col-md-12">
                <div class="alert alert-info" v-html="info"></div>
            </div>
        </div>
        <div class="row mb-2 mt-3">
            <h2 class="col-md-12 font-weight-bold">
                Property Photos
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input-group :errors="errors" id="PropertyImages" name="PropertyImages" label="Property Images" type="image" placeholder="Choose Files" help="<b>Note: </b> You can only have 10 property images per listing. Maximum image size: 3MB." multiple></input-group>
            </div>
        </div>
        <div class="row col-md-12 d-flex justify-content-start">
            <div class="removable mx-auto mt-2" v-for="image in images" @click.prevent="remove_image(image)">
                <img :src='image.src' class="img-fluid"/>
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
            <div class="col-md-5">
                <input-group :errors="errors" id="PropertyFiles" name="PropertyFiles" label="Property Files" type="file" placeholder="Choose Files" help="<b>Note: </b> You can only submit 5 property files per listing. Maximum image size: 5MB." accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" multiple></input-group>
            </div>
            <div class="col-md-7">
                <div class="row"  v-for="file in files">
                    <div class="alert w-100 alert-sm alert-dismissible alert-light mb-2">
                        <span>@{{file.name}}</span>
                        <button type="button" class="close" @click.prevent="remove_file(file)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <multi-select :Values="values" :errors="errors" :options="options" name="Amenities" label="Amenities"></multi-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 align-self-end mt-2 text-right">
                <input-group type="check" :errors="errors" :values="values" name="panorama" id="panorama" label="Request 360&#176; panoramas"></input-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="alert alert-success" v-if="success" v-html="success"></div>
            </div>
            <div class="col-md-8">
                <div class="alert alert-danger" v-if="error" v-html="error"></div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="px-4 btn btn-sm btn-sm-block btn-xs-block btn-md-block btn-primary float-right">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                    Post Listing
                </button>
            </div>
        </div>
    </form>
@endsection