@extends('layouts.app')

@section('header')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2@4.1.0/dist/bootstrap-confirmation.min.js" integrity="sha256-HLaBCKTIBg6tnkp3ORya7b3Ttkf7/TXAuL/BdzahrO0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.pannellum.org/2.4/pannellum.css"/>
    <script type="text/javascript" src="https://cdn.pannellum.org/2.4/pannellum.js"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css'/>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css'/>

    <style>
        .owl-carousel img {
            cursor: pointer;
        }

        .owl-carousel img:hover {
            opacity: 0.8 !important;
        }
    </style>
@endsection

@section('content')
    <script>
        function openImage(link) {
            let elem = $(link)
            $('#imagepreview').attr('src', elem.attr('data-src'));
            $('#imglink').text(elem.attr('data-src'));
            $('#imglink').attr("href", elem.attr('data-src'));
            $('#imagemodal').modal('show');
        }

        function viewPanorama(link) {
            let pano = $(link).attr('data-pano')
            $("#panorama").empty()

            pannellum.viewer('panorama', {
                "type": "equirectangular",
                "panorama": '/' + pano,
            })

            $("#panomodal").modal("show")
        }
    </script>

    @if (Auth::check() && Auth::user()->id == $property->user->id)
        <script>
            let propertyID = {{$property->id}}
            
            let defaultValues = {
                Name: "{{$property->Name}}",
                Description: "{{$property->Description}}",
                Developer: "{{$property->Developer}}",
                LotNo: "{{$property->LotNo}}",
                Street: "{{$property->Street}}",
                City: "{{$property->City}}",
                Country: "{{$property->Country}}",
                YearBuilt: {{$property->YearBuilt}},
                FloorArea: {{$property->FloorArea}},
                LotArea: {{$property->LotArea}},
                Price: {{$property->Price}},
                NumberOfBedrooms: {{$property->NumberOfBedrooms}},
                NumberOfBathrooms: {{$property->NumberOfBathrooms}},
                CapacityOfGarage: {{$property->CapacityOfGarage}},
                PropertyTypeID: {{$property->PropertyTypeID}},
                ListingTypeID: {{$property->ListingTypeID}},
            }

            let selectedAmenities = '{{{$property->amenity}}}'
            selectedAmenities = JSON.parse(selectedAmenities.replace(/&quot;/g, "\""))
            let actualSelected = []

            $.each(selectedAmenities, (i, o) => {
                actualSelected.push(o.id + "")
            })

            defaultValues.Amenities = actualSelected

        </script>
            
        <form action="" id="vue-property-update">
            <div class="modal fade" id="updateProperty" tabindex="-1" role="dialog" aria-labelledby="updatePropertyLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            </div>
                            <div class="modal-body container">
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
                                                        <input-group :errors="errors" :values="values" name="Country" :countries="countries" type="country" id="country" placeholder="-- Country --" required></input-group>
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
                                <div class="row" v-if="success">
                                    <div class="col-md-12">
                                        <div class="alert alert-success" v-html="success"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-5">
                                            <button type="button" class="btn btn-sm btn-block btn-primary mr-3" data-toggle="confirmation" id="update" data-content="This will change your property post details.">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                                Update Property Details
                                            </button>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-sm btn-block btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </form>
    @endif

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
              <img src="" id="imagepreview" class="d-block mx-auto" style="width: 100%; height: auto;" >
            </div>
            <div class="modal-footer justify-content-between">
              <a class="small text-muted" id="imglink"></a>
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

    @php
        $panoCount = ($property->property_document != null) ? count($property->property_document->Images['3d']) : 0;
    @endphp
    @if ($panoCount > 0)
        <div class="modal fade" id="panomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-capitalize font-weight-bold" id="panotitle"></h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <div id="panorama" style="height: 300px; width: 100%;" class="d-block mx-auto"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="owl-carousel owl-theme" id="images">
                        @foreach ($property->property_document->Images['3d'] as $key => $value)
                            <img class="owl-lazy d-block p-1" data-src="/{{$value}}" alt="" height="70px" width="auto" onclick="viewPanorama(this)" data-pano="{{$value}}" data-title="{{$key}}">
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        </div>
    @endif

    <div class="photos owl-carousel owl-theme px-5" style="min-height: 350px;">
        <?php $count = isset($property->property_document) ? count($property->property_document->Images['regular']) : 0?>
        @for ($i = 0; $i < $count; $i++)
            <div>
                <img onclick="openImage(this)" class="owl-lazy d-block mx-auto" style="height: 350px !important; width: auto;" data-src="{{$property->property_document->Images['regular'][$i]}}" alt="">
            </div>
        @endfor
        @if ($count == 0)
            <div></div>
        @endif
    </div>
    
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if (Auth::check() && Auth::User()->id == $property->UserID)
                    <script>
                        let archive = {{$property->Status->id}} == 1
                        function toggleArchive() {
                            $("#archive .spinner-border").removeAttr('hidden')
                            $("#archive").attr("disabled", "disabled")
                            let alertDiv = $('<div role="alert"></div>')
                                    .addClass("alert alert-sm alert-success alert-dismissable fade show w-100 mt-2");
                            let text = $("<span></span>")

                            $.ajax({
                                url: "/properties/toggleArchive/{{$property->id}}",
                                method: "GET",
                                success: (e) => {
                                    if (archive) // from available to archived
                                        $("#archive").attr("data-content", "This will allow your property to show up in searches").text("Unarchive Property").removeClass("btn-danger").addClass("btn-success")
                                    else
                                        $("#archive").attr("data-content", "This will prevent your property from showing up in searches").text("Archive Property").removeClass("btn-success").addClass("btn-danger")
                                    
                                    archive = !archive
                                    $.each(e.message, (i, v) => text.text(v))
                                },
                                error: (e) => {
                                    alertDiv.removeClass("alert-success").addClass("alert-danger");
                                    text.text("An error occured while updating this property post, please try again...")
                                }
                            }).always((e) => {
                                let close = $('<button></button>')
                                    .addClass("close")
                                    .attr("data-dismiss", "alert")
                                    .html("&times;")

                                alertDiv
                                    .append(text)
                                    .append(close)
                                
                                $("#alertRow").empty().append(alertDiv)
                                
                                $("#archive .spinner-border").attr('hidden', 'hidden')
                                $("#archive").removeAttr("disabled")
                            })
                        }
                    </script>
                    <button class="btn btn-sm btn-sm-block btn-xs-block mt-2 btn-primary" data-toggle="modal" data-target="#updateProperty">Edit Property Details</button>
                    @if ($property->Status->Status != "Available")
                        <button class="btn btn-sm btn-sm-block btn-xs-block mt-2 btn-success" data-toggle="confirmation" id="archive" data-content="This will allow your property to show up in searches">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                            Unarchive Property
                        </button>
                    @else
                        <button class="btn btn-sm btn-sm-block btn-xs-block mt-2 btn-danger" data-toggle="confirmation" id="archive" data-content="This will prevent your property from showing up in searches">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                            Archive Property
                        </button>
                    @endif
                    <script>
                        $("#archive").confirmation({
                            onConfirm: toggleArchive
                        })
                    </script>
                @else
                    @if (Auth::check())
                    <script>
                            function converse(id) {
                                $.ajax({
                                    url: '/conversations/converse/' + id,
                                    method: "GET",
                                    success: (e) => {
                                        window.location = "/users?segment=messages&id=" + id
                                    }
                                }).always((e) => console.log(e))
                            }
                        </script>
                        <button class="btn btn-sm btn-sm-block btn-xs-block mt-2 btn-primary" onclick="converse({{$property->user->id}})">Say Hi!</button>
                    
                    @endif
                @endif
            </div>
        </div>
        <div class="row col-md-12" id="alertRow">
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <h2><b>{{$property->Name}}</b></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-muted">
                <h6><b>Feedback: </b> {{$property->feedback_value() == null ? 0.0 : $property->feedback_value()}} / 5.0</h6>
                @if (Auth::check() && !Auth::user()->has_voted($property->id))
                    <b class="mr-2">Leave a Feedback: </b> 
                    <a href="/properties/vote/1/{{$property->id}}" class="btn btn-sm btn-primary">Vote 1</a>
                    <a href="/properties/vote/2/{{$property->id}}" class="btn btn-sm btn-primary">Vote 2</a>
                    <a href="/properties/vote/3/{{$property->id}}" class="btn btn-sm btn-primary">Vote 3</a>
                    <a href="/properties/vote/4/{{$property->id}}" class="btn btn-sm btn-primary">Vote 4</a>
                    <a href="/properties/vote/5/{{$property->id}}" class="btn btn-sm btn-primary">Vote 5</a>
                @endif
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12 text-muted">
                <h6><b>Price: &#8369; {{number_format($property->Price, 2)}}</b></h6>
                <p>
                    {{$property->Description}}
                </p>
                @if ($panoCount > 0)
                    <a href="#" onclick="viewPanorama(this)" data-pano="{{$property->property_document->Images['3d'][array_keys($property->property_document->Images['3d'])[0]]}}">View 3D Panoramas</a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row mt-5">
                    <div class="col-md-12">
                        <h5><b>Property Details</b></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <span class="text-muted">Listing Type</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-capitalize">For {{$property->listing_type->ListingType}}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <span class="text-muted">Property Type</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-capitalize">{{$property->property_type->PropertyType}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <span class="text-muted">Property ID</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-capitalize">{{$property->id}}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <span class="text-muted">Property Status</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-capitalize">{{$property->status->Status}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                        <span class="text-muted col-md mt-2">
                            <i class="fas fa-bed"></i>
                            {{$property->NumberOfBedrooms}} Bed/s
                        </span>
    
                        <span class="text-muted col-md mt-2">
                            <i class="fas fa-bath"></i>
                            {{$property->NumberOfBathrooms}} Baths/s
                        </span>
    
                        <span class="text-muted col-md mt-2">
                            <i class="fas fa-home"></i>
                            {{$property->FloorArea}} sqm.
                        </span>

                        <span class="text-muted col-md mt-2">
                            <i class="fas fa-car-side"></i> 
                            {{$property->CapacityOfGarage}} Car Space
                        </span>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h5><b>Additional Information</b></h5>
                    </div>
                </div>
                @if(Auth::check() && Auth::user()->user_type->id == 3)
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="text-muted">
                                Files
                            </div>
                        </div>
                        <div class="col-md-6">
                            @foreach ($property->property_document->Files as $item)
                                <a href="{{$item}}">
                                    item
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="text-muted">
                            Lot Number
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{$property->LotNo}}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="text-muted">
                            Street
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{$property->Street}}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="text-muted">
                            City
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{$property->City}}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="text-muted">
                            Country
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{$property->Country}}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="text-muted">
                            Property Developer
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{$property->Developer}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="row mt-2">
                    <div class="col-md-12">
                        <h5><b>Property Amenities</b></h5>
                    </div>
                </div>
                @if (count($property->property_amenity) > 0)
                    <div class="row">
                        <div class="col-md-6">
                            @for ($i = 0; $i <= count($property->property_amenity) / 2; $i++)
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        {{$property->property_amenity[$i]->amenity->AmenityName}}
                                    </div>
                                </div>
                            @endfor
                        </div>
    
                        <div class="col-md-6">
                            @for ($i = count($property->property_amenity) / 2 + 1; $i < count($property->property_amenity); $i++)
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        {{$property->property_amenity[$i]->amenity->AmenityName}}
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <h6><i class="text-muted">No Property amenities specified.</i></h6>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        $('.photos').owlCarousel({
            loop:false,
            lazyLoad:true,
            responsive:{
                0:{
                    items:1
                },
                1024:{
                    items:2
                }
            }
        })

        $('#images').owlCarousel({
            loop:false,
            lazyLoad:true,
            items: 5,
            responsive:{
                0:{
                    items:1
                },
                1024:{
                    items: 5
                }
            },
        })
    </script>
@endsection