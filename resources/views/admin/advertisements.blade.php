@extends('layouts.app')

@section('header')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2@4.1.0/dist/bootstrap-confirmation.min.js"
    integrity="sha256-HLaBCKTIBg6tnkp3ORya7b3Ttkf7/TXAuL/BdzahrO0=" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="container w-75 pt-5">
    @php
    $advertisements = App\Advertisement::orderBy('created_at', 'DESC')->simplePaginate(10);
    @endphp

    <h1 class="border-bottom row mb-5">Site Advertisements</h1>
    <form class="row" method="post" enctype="multipart/form-data" action="/admin/advertisements">
        @csrf
        <div class="col-md">
            <div class="form-group">
                <label for="Title" class="form-label">Advertisement Link:</label>
                <input type="text" name="Title" id="Title" placeholder="Enter advertisement title here..." class="form-control" required>
            </div>
        </div>
        <div class="col-md">
            <label for="Image" class="form-label">Image</label>
            <div class="custom-file">
                <input type="file" name="Image" id="Image" class="custom-file-input" accept="image/*" required>
                <label for="Image" class="custom-file-label">Select Advertisement Image</label>
            </div>
        </div>
        <div class="col-md">
            <div class="form-group">
            <label style="display: block;">&nbsp;</label>
            <input type="submit" value="Create Advertisement" class="btn btn-success">
            </div>
        </div>
    </form>
    @if (Session::has('success'))
    <div class="row">
            <div class="col">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <b>Success: </b> An advertisements has been added.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if (Session::has('info'))
    <div class="row">
            <div class="col">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <b>Info: </b> An advertisements has been deleted.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <div class="row mt-3">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Ad ID</th>
                            <th scope="col">Link</th>
                            <th scope="col">Image Link</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($advertisements as $advertisement)
                        <tr>
                            <th scope="row">{{$advertisement->id}}</th>
                            <td scope="col">{{$advertisement->Title}}</td>
                            <td scope="col"><a href="{{$advertisement->Image}}" target="_blank">{{$advertisement->Image}}</a></td>
                            <td scope="col"><a href="/admin/advertisements/remove/{{$advertisement->id}}" class="btn btn-danger">Remove Ad</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-right">
            {{$advertisements->links()}}
        </div>
    </div>
</div>
@endsection
