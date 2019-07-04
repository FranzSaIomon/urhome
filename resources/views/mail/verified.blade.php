@extends('layouts.mail')

@section('content')
<div style="min-height: 500px; background-color: #fff; padding: 15px; border-radius: 5px; width: 50%; margin: 15px auto;">
    <div class="row my-3 py-3 border-bottom" style="padding: 10px auto; border-bottom: 1px solid #e2e2e2; margin: 10px auto; text-align:center;">
        <div class="col text-center">
            <h2>Congratulations</h2>
        </div>
    </div>

    <div class="row" style="text-align: center;">
        <div class="col text-center">
            <p>Your account at <a href="urhome.test">urhome</a> has been verified as a valid Broker</p>
            <p>You can login now and subscribe to our different plans such as Basic, Standard, Business, and Premium!
            </p>
        </div>
    </div>
</div>
@endsection
