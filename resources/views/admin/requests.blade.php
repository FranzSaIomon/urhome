@extends('layouts.app')

@section('header')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2@4.1.0/dist/bootstrap-confirmation.min.js" integrity="sha256-HLaBCKTIBg6tnkp3ORya7b3Ttkf7/TXAuL/BdzahrO0=" crossorigin="anonymous"></script>
@endsection

@section('content')
@php
$panoramas = App\PanoramaRequest::paginate(15);
@endphp
<div class="container w-75 pt-5">

    <h1 class="border-bottom row mb-5">Panorama Requests</h1>

    @if (Session::has('success'))
    <div class="row">
            <div class="col">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <b>Success: </b> A property has been updated.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-md-3">
            {{$panoramas->links()}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <th scope="row">
                        Request ID
                    </th>
                    <th scope="col">
                        Property Name
                    </th>
                    <th scope="col">
                        Action
                    </th>
                </thead>
                <tbody>
                    @foreach ($panoramas as $panorama)
                    <tr>
                        <td scope="row">{{$panorama->id}}</td>
                        <td scope="col">{{$panorama->property->Name}}</td>
                        <td scope="col">
                            <form action="/admin/requests/{{$panorama->property->id}}" class="row" method="post" enctype="multipart/form-data" >
                                @csrf
                                <div class="custom-file col-md-9 mx-2 mt-2">
                                    <input type="file" name="Image" id="Image" class="custom-file-input" accept="image/*" required multiple>
                                    <label for="Image" class="custom-file-label">Select Panorama Images</label>
                                </div>

                                <input type="submit" value="Upload" class="btn btn-success btn-sm col-md-2 mx-2 mt-2">
                            </form>    
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            {{$panoramas->links()}}
        </div>
    </div>
</div>
@endsection