@extends('layouts.app')

@section('content')
    @include('includes.landing')

    @php
        $brokers = App\BrokerInformation::where('SubscriptionID', '>=', 3)->get();
        $user_id = array();

        foreach ($brokers as $broker)
            array_push($user_id, $broker->UserID);
        
        $ptypes = App\PropertyType::all();
        $i = 0;
    @endphp
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="border-bottom pb-3 mb-3"><b>Featured Listings</b></h2>
            </div>
        </div>

        @foreach ($ptypes as $ptype)
            @if($i != 0 && $i % 2 == 0)
                @php
                    $ad = App\Advertisement::inRandomOrder()->first();
                @endphp

                @if (isset($ad))
                    <div class="row">
                        <div class="col text-center">
                            <a href="{{$ad->Title}}">
                                <img src="{{$ad->Image}}" alt="{{$ad->Title}}" style="height: 70px; width: auto;">
                            </a>
                        </div>
                    </div>
                @endif
            @endif

            @php
                $i++;    
            @endphp
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mt-5">{{$ptype->PropertyType}}</h5>
                    @php
                        $properties = App\Property::whereIn('UserID', $user_id)->where('PropertyTypeID', $ptype->id)->inRandomOrder()->limit(3)->get();
                    @endphp

                    <div class="row">
                            @foreach ($properties as $property)
                            <div class="col-md-4 properties">
                                <a href="/properties/view/{{$property->id}}" class="card">
                                    <div class="badge {{$property->listing_type->id == 1 ? 'rent' : 'sale'}}">For {{$property->listing_type->ListingType}}</div>
                                    @if($property->property_document != null)
                                        <img src="{{count($property->property_document->Images['regular']) <= 0 ? 'https://via.placeholder.com/282' : $property->property_document->Images['regular'][0]}}"  class="lazy text-center card-img-top" style="min-height: 282.4px">
                                    @else
                                        <img src="https://via.placeholder.com/282"  class="lazy text-center card-img-top" style="min-height: 282.4px">
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-subtitle">{{$property->property_type->PropertyType}} | {{$property->City}} </h6>
                                        <h4 class="card-title">{{$property->Name}}</h4>
                                        <div class="footer">
                                            <span class="text-muted">
                                                <i class="fas fa-bed"></i>
                                                {{$property->NumberOfBedrooms}} Bed/s
                                            </span>
                        
                                            <span class="text-muted">
                                                <i class="fas fa-bath"></i>
                                                {{$property->NumberOfBathrooms}} Baths/s
                                            </span>
                        
                                            <span class="text-muted">
                                                <i class="fas fa-home"></i>
                                                {{$property->FloorArea}} sqm.
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
