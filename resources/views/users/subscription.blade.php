@extends('layouts.app')

@section('header')
@endsection
@section('content')
<script>
    var callback = (e) => {
        e.preventDefault()
        $("#form").attr('action', $(e.target).attr('href'))
        $("#form").trigger("submit")
    }
</script>
@if (Session::has("message"))
    <div class="alert alert-info m-5">
        <b>Info: </b> Your subscription has either expired or you are a newly verified broker. Please purchase a package below to continue using our services below.
    </div>
@endif
<form class="container mx-auto pt-5" id="form" method="POST">
    @csrf
    <div class="row justify-content-center">
        <div class="col-md-3 m-2 card bg-white border text-center">
            <h2 class="card-title p-5 mt-5">Basic</h2>
            <div class="card-body border-top">
                <h5 class="card-title">Php. 1,119.00</h5>
                <div class="card-text">
                    <h6 class="mt-2"><b>Features</b></h6>
                    <div>Max Listings: 5</div>
                    <div>Instant Messaging</div>
                    <div>Property Posting</div>
                    <div>1 Month Period</div>
                </div>

                <input type="submit" onclick="callback(event)" href="paypal/subscribe/1" class="btn btn-primary my-4" value="Subscribe Here">
            </div>
        </div>
        <div class="col-md-3 m-2 card bg-white border text-center">
            <h2 class="card-title p-5 mt-5">Standard</h2>
            <div class="card-body border-top">
                <h5 class="card-title">Php. 1,499.00</h5>
                <div class="card-text">
                    <h6 class="mt-2"><b>Features</b></h6>
                    <div>Max Listings: 10</div>
                    <div>Instant Messaging</div>
                    <div>Property Posting</div>
                    <div>Report Generation</div>
                    <div>4 Month Period</div>
                </div>

                <input type="submit" onclick="callback(event)" href="paypal/subscribe/2" class="btn btn-primary my-4" value="Subscribe Here">
            </div>
        </div>
        <div class="col-md-3 m-2 card bg-white border text-center">
            <h2 class="card-title p-5 mt-5">Business</h2>
            <div class="card-body border-top">
                <h5 class="card-title">Php. 1,899.00</h5>
                <div class="card-text">
                    <h6 class="mt-2"><b>Features</b></h6>
                    <div>Max Listings: 15</div>
                    <div>Instant Messaging</div>
                    <div>Property Posting</div>
                    <div>Report Generation</div>
                    <div>1 Featured Listing</div>
                    <div>6 Month Period</div>
                </div>

                <input type="submit" onclick="callback(event)" href="paypal/subscribe/3" class="btn btn-primary my-4" value="Subscribe Here">
            </div>
        </div>
        <div class="col-md-3 m-2 card bg-white border text-center">
            <h2 class="card-title p-5 mt-5">Premium</h2>
            <div class="card-body border-top">
                <h5 class="card-title">Php. 2,699.00</h5>
                <div class="card-text">
                    <h6 class="mt-2"><b>Features</b></h6>
                    <div>Max Listings: 30</div>
                    <div>Instant Messaging</div>
                    <div>Property Posting</div>
                    <div>Report Generation</div>
                    <div>3 Featured Listing</div>
                    <div>12 Month Period</div>
                </div>

                <input type="submit" onclick="callback(event)" href="paypal/subscribe/4" class="btn btn-primary my-4" value="Subscribe Here">
            </div>
        </div>
    </div>
</form>
@endsection
