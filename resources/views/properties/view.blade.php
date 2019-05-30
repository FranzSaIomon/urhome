@extends('layouts.app')

@section('content')
    <script>
        function openImage(link) {
            let elem = $(link).find("img")
            $('#imagepreview').attr('src', elem.attr('data-src'));
            $('#imglink').text(elem.attr('data-src'));
            $('#imglink').attr("href", elem.attr('data-src'));
            $('#imagemodal').modal('show');
        }
    </script>
    <!-- Creates the bootstrap modal where the image will appear -->
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
              <img src="" id="imagepreview" class="d-block mx-auto" style="width: auto; height: 500px;" >
            </div>
            <div class="modal-footer justify-content-between">
              <a class="small text-muted" id="imglink"></a>
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

    <div class="photos owl-carousel px -5">
        <?php $count = count($property->property_document->Images['regular']) ?>
        @for ($i = 0; $i < $count; $i++)
            <div>
                <a onclick="openImage(this)">
                    <img class="owl-lazy d-block mx-auto" style="height: 350px !important; width: auto;" data-src="{{$property->property_document->Images['regular'][$i]}}" alt="">
                </a>
            </div>

            @if ($count % 2 != 0 && $i == $count - 1)
                <div></div>
            @endif
        @endfor
    </div>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2><b>{{$property->Name}}</b></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-muted">
                {{$property->Description}}
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <h5><b>Property Details</b></h5>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>
    </div>
    {{ $property }}

    <script>
        $('.photos').owlCarousel({
            loop:false,
            lazyLoad:true,
            dots: false,
            responsive:{
                0:{
                    items:1
                },
                1024:{
                    items:2
                }
            }
        })
    </script>
@endsection