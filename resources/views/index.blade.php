@extends('layouts.master')
@section('content')
<div class="container">
    <form id="fileUploadForm" action="/submit" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card card-default m-3">
            <div class="row m-4">
                <div class="col-md-10"><input id="file" type="file" name="file" class="dropify" data-allowed-file-extensions="csv" required /></div>
                <div class="col-md-2"><button id="uploadButton" type="submit" class="btn btn-secondary">Upload File</button></div>
            </div>
        </div>

        <div id="progressDiv" class="form-group" style="display:none">
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </div>
    </form>
    <div class="card card-default m-3 p-1">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Time</th>
                    <th scope="col">File Name</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection