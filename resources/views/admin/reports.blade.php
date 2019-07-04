@extends('layouts.app')

@section('header')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2@4.1.0/dist/bootstrap-confirmation.min.js"
    integrity="sha256-HLaBCKTIBg6tnkp3ORya7b3Ttkf7/TXAuL/BdzahrO0=" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="container w-50 mx-auto pt-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <a href="javascript:window.print()" class="no-print btn btn-block btn-success">Print Report</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="col">Total For Sale Listings</th>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 2)->get())}}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">Total For Rent Listings</th>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 1)->get())}}
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <th scope="col">Total Listings</th>
                            <td scope="col">
                                {{count(App\Property::all())}}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">Total Registered Users</th>
                            <td scope="col">{{count(App\User::all())}}</td>
                        </tr>
                    </tbody>
                </table>
                </table>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Property Type</th>
                            <th scope="col">For Sale</th>
                            <th scope="col">For Rent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="col">Town House</th>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 1)->where('PropertyTypeID', 1)->get())}}
                            </td>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 2)->where('PropertyTypeID', 1)->get())}}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">House</th>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 1)->where('PropertyTypeID', 2)->get())}}
                            </td>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 2)->where('PropertyTypeID', 2)->get())}}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">Condominium</th>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 1)->where('PropertyTypeID', 3)->get())}}
                            </td>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 2)->where('PropertyTypeID', 3)->get())}}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">Condotel</th>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 1)->where('PropertyTypeID', 4)->get())}}
                            </td>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 2)->where('PropertyTypeID', 4)->get())}}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">Service Apartment</th>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 1)->where('PropertyTypeID', 5)->get())}}
                            </td>
                            <td scope="col">
                                {{count(App\Property::where('ListingTypeID', 2)->where('PropertyTypeID', 5)->get())}}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">User Type</th>
                            <th scope="col">Total Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Client</th>
                            <td>
                                {{count(App\User::where('UserType', 1)->get())}}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Broker</th>
                            <td>
                                {{count(App\User::where('UserType', 2)->get())}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
