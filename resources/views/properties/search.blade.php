@extends('layouts.app')

@section('content')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.sticky/1.0.4/jquery.sticky.min.js'></script>
    
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-3 position-relative">
                <form class="p-4 bg-white rounded filter" action="" id="vue-simple-search" @submit.prevent="search(true)">
                    <input-group :errors="errors" :values="values" name="query" label="Search"></input-group>
                    <toggle-button ref="purpose" :toggles="toggles" name="purpose" :default-name="'For Rent or Sale'" :default-value="'all'" :errors="errors" :values="values"></toggle-button>
                    <div class="mt-3">
                        <multi-select :values="values" :errors="errors" label="Property Types" name="type" :options="options"></multi-select>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Search
                    </button>
                    <div id="search_details" class="collapse mt-3">
                        <input-group :values="values" :errors="errors" name="location" label="Location" placeholder="Location..." id="location"></input-group>

                        <div class="form-group">
                            <slider :values="values" ref="NumberOfBedrooms" :errors="errors" label="Bedrooms" name="NumberOfBedrooms" min=1 step=1 max=10></slider>
                        </div>

                        <div class="form-group">
                            <slider :values="values" ref="NumberOfBathrooms" :errors="errors" label="Bathrooms" name="NumberOfBathrooms" min=0 step=1 max=10></slider>
                        </div>

                        <div class="form-group">
                            <slider :values="values" :errors="errors" label="Price Range" inclusive="true" ref="Price" name="Price" min=0 max=1000000 currency="true"
                            step=1 maximums="10000, 1000000, 10000000, 100000000, 1000000000" prefix="&#8369;"></slider>
                        </div>

                        <div class="form-group">
                            <slider :values="values" :errors="errors" label="Lot Size" inclusive="true" ref="LotArea" name="LotArea" min="0" max="10000"
                            step="1" maximums="100, 1000, 10000, 100000, 1000000, 10000000, 100000000" suffix="sqm."></slider>
                        </div>
                        
                        <div class="form-group">
                            <slider :values="values" :errors="errors" label="Floor Size" inclusive="true" ref="FloorArea" name="FloorArea" min="0" max="10000"
                            step="1" maximums="100, 1000, 10000, 100000, 1000000, 10000000, 100000000" suffix="sqm."></slider>
                        </div>
                    </div>
                    <div class="text-center my-3">
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="ignoreAdvanced" id="ignoreAdvanced" v-model="ignoreAdvanced" class="custom-control-input">
                            <label for="ignoreAdvanced" class="custom-control-label" style="font-weight: normal;">Ignore Advanced Details</label>
                        </div>
                        <button type="button" class="btn" :disabled="(ignoreAdvanced) ? 'disabled' : false" :data-toggle="(!ignoreAdvanced) ? 'collapse' : ''" data-target="#search_details" @click.prevent="shown = (!ignoreAdvanced) ? !shown : shown"><i :class="'fas ' + ((!shown) ? 'fa-angle-double-down' : 'fa-angle-double-up')"></i> <span class="ml-1">Advanced Details</span></button>
                    </div>
                </form>
            </div>
            <div class="col-md-9">
                <div id="properties_cards" class="mt-2">
                    <div class="small text-muted mb-2 ml-3">Search Results Found: <b>@{{resultCount}} properties</b></div>
                    <Properties :cards="cards"></Properties>
                    <div class="text-center">
                        <div :class="'spinner-border text-muted ' + ((!loading) ? 'd-none' : '')"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection