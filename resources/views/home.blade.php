@extends('layouts.app')

@section('content')
    <div class="landing">

        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Find Your Next Home</h1>
                </div>
            </div>
            <div class="row">
                <form action="" class="container">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <select class="custom-select custom-select-sm">
                                <option value="1">Townhouse</option>
                                <option value="2">Commercial</option>
                                <option value="3">Building</option>
                                <option value="4">Condominium</option>
                                <option value="5">Warehosue</option>
                                <option value="6">House</option>
                                <option value="7">Lot</option>
                                <option value="8">Beachfront</option>
                                <option value="9">Storage</option>
                                <option value="10">Office</option>
                                <option value="11">Island</option>
                                <option value="12">Memorial Lot</option>
                                <option value="13">Service Apartment</option>
                                <option value="14">Condotel</option>
                                <option value="15">Retail</option>
                            </select>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" name="q" id="q" placeholder="Search Here..." class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="submit" value="Search" class="btn btn-block btn-sm btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection