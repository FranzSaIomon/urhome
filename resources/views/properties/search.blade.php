@extends('layouts.app')

@section('content')
    @include('includes.filter', ["local" => "local"])

    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-3">
                <form class="p-4 bg-white rounded filter" action="" id="vue-simple-search" @submit.prevent="search">
                    <input-group :errors="errors" :values="values" name="query" label="Search"></input-group>
                    <toggle-button type="joined" ref="purpose" :toggles="toggles" name="purpose" :default-name="'For Rent or Sale'" :default-value="'all'" :errors="errors" :values="values"></toggle-button>
                    <br/>
                    <multi-select :values="values" :errors="errors" label="Property Types" name="type" :options="options"></multi-select>
                    <div class="text-center mt-1 d-none d-md-block d-lg-none"><a href="#" data-toggle="modal" data-target="#filterModal">Advanced Search</a></div>
                    <br/>
                    <button type="submit" class="btn btn-block btn-primary">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Search
                    </button>
                    <br/>
                    <div class="d-none d-lg-block">
                        <input-group :values="values" :errors="errors" name="location" label="Location" placeholder="Location..." id="location"></input-group>

                        <div class="form-group">
                            <slider :values="values" ref="NumberOfBedrooms" :errors="errors" label="Bedrooms" name="NumberOfBedrooms" min=1 step=1 max=10></slider>
                        </div>

                        <div class="form-group">
                            <slider :values="values" ref="NumberOfBathrooms" :errors="errors" label="Bathrooms" name="NumberOfBathrooms" min=0 step=1 max=10></slider>
                        </div>

                        <div class="form-group">
                            <slider :values="values" :errors="errors" label="Price Range" inclusive="true" ref="Price" name="Price" min=0 max=1000000 currency="true"
                            step=1 maximums="10000, 1000000, 10000000, 10000000, 1000000000" prefix="&#8369;"></slider>
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
                </form>
            </div>
            <div class="col-md-9">
                <div id="properties_cards">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                            <a class="page-link" href="#"  @click.prevent="changePage(page - 1)" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                            </li>
                            <li :class="{'page-item' : true, 'active' : page == page0}"  v-for="page0 in pages" :key="page0">
                                <a href="#" class="page-link" @click.prevent="changePage(page0)">@{{page0}}</a>
                            </li>
                            <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next"  @click.prevent="changePage(page + 1)">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                            </li>
                        </ul>
                    </nav>
                    <Properties :cards="cards"></Properties>
                </div>
            </div>
        </div>
    </div>
@endsection