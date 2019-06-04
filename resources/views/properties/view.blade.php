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
            let title = $(link).attr('data-title')
            $("#panorama").empty()

            pannellum.viewer('panorama', {
                "type": "equirectangular",
                "panorama": '/' + pano,
            })

            $("#panomodal").modal("show")
            $("#panotitle").text(title)
        }
    </script>

    <script>
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
        }

        let selectedAmenities = '{{{$property->amenity}}}'
        selectedAmenities = JSON.parse(selectedAmenities.replace(/&quot;/g, "\""))
        
    </script>
    <div class="modal fade" id="updateProperty" tabindex="-1" role="dialog" aria-labelledby="updatePropertyLabel" aria-hidden="true">
        <form action="" id="vue-property-update">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body container">
                        <input-group :values="values" :errors="errors" name="Name" label="Property Name" placeholder="Property Name"></input-group>
                        <multi-select :Values="values" :errors="errors" :options="options" name="Amenities" label="Amenities"></multi-select>
                    </div>
                    <div class="modal-footer justify-content-between">
                    <a class="small text-muted" id="imglink"></a>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

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
        $panoCount = count($property->property_document->Images['3d']);
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
                            $("#archive").removeClass("btn-danger").removeClass("btn-success");

                            $.ajax({
                                url: "/properties/toggleArchive/{{$property->id}}",
                                method: "GET",
                                success: (e) => {
                                    if (archive) // from available to archived
                                        $("#archive").attr("data-content", "This will allow your property to show up in searches").text("Unarchive Property").addClass("btn-success")
                                    else
                                        $("#archive").attr("data-content", "This will prevent your property from showing up in searches").text("Archive Property").addClass("btn-danger")
                                    
                                    archive = !archive
                                },
                                error: (e) => {
                                }
                            }).always((e) => {
                                let alertDiv = $('<div role="alert"></div>')
                                    .addClass("alert alert-sm alert-success alert-dismissable fade show w-100 mt-2");
                                let text = $("<span></span>")
                                let close = $('<button></button>')
                                    .addClass("close")
                                    .attr("data-dismiss", "alert")
                                    .html("&times;")

                                $.each(e.message, (i, v) => text.text(v))

                                alertDiv
                                    .append(text)
                                    .append(close)
                                
                                $("#alertRow").empty().append(alertDiv)
                            })
                        }
                    </script>
                    <button class="btn btn-sm btn-sm-block btn-xs-block mt-2 btn-primary" data-toggle="modal" data-target="#updateProperty">Edit Property Details</button>
                    @if ($property->Status->Status != "Available")
                        <button class="btn btn-sm btn-sm-block btn-xs-block mt-2 btn-success" data-toggle="confirmation" id="archive" data-content="This will allow your property to show up in searches">Unarchive Property</button>
                    @else
                        <button class="btn btn-sm btn-sm-block btn-xs-block mt-2 btn-danger" data-toggle="confirmation" id="archive" data-content="This will prevent your property from showing up in searches">Archive Property</button>
                    @endif
                @else
                    <button class="btn btn-sm btn-sm-block btn-xs-block mt-2 btn-primary">Message Seller</button>
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
                <p>
                    {{$property->Description}}
                </p>
                @if ($panoCount > 0)
                    <a href="#" onclick="viewPanorama(this)" data-title="{{array_keys($property->property_document->Images["3d"])[0]}}" data-pano="{{$property->property_document->Images['3d'][array_keys($property->property_document->Images['3d'])[0]]}}">View 3D Panoramas</a>
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
                <div class="row">
                    <div class="col-md-6">
                        @for ($i = 0; $i < count($property->property_amenity) / 2; $i++)
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
            </div>
        </div>
    </div>

    <script>
        $("#archive").confirmation({
            onConfirm: toggleArchive
        })

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