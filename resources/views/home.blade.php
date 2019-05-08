@extends('layouts.app')

@section('content')
    <div class="landing">
        <form class="grid-container" action="" method="GET">
            <div class="row">
                <div class="twelve columns">
                    <h1>Find Your Next Home</h1>
                </div>
                <div class="row">
                    <div class="twelve columns">
                        <div class="button-pill" id="purpose">
                            <button data-value="rent">For Rent</button><button data-value="sale">For Sale</button>
                            <input type="hidden" name="purpose" value="all">
                        </div>

                        <script>
                            $("#purpose button").click((e) => {
                                e.preventDefault();
                                let prevSelected = $("#purpose button.selected");
                                
                                $("#purpose button").removeClass("selected");

                                if (prevSelected.attr("data-value") !== $(e.target).attr("data-value")) {
                                    $("[name=purpose]").val($(e.target).attr("data-value"));
                                    $("#purpose button[data-value=" + $(e.target).attr("data-value") + "]").addClass("selected");
                                } else
                                    $("[name=purpose]").val("all");
                            })
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="four columns">
                        <select class="u-full-width">
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
                    <div class="eight columns">
                        <div class="row">
                            <div class="eight columns iconed-input">
                                <label class="fas fa-search" for="q"></label>
                                <input type="text" class="u-full-width" name="q" id="q" placeholder="Search here...">
                            </div>
    
                            <div class="three columns centered">
                                <input type="submit" value="Search" class="button-primary full-mobile">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection