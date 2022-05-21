<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>YoPrint</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

        <!-- Datatable -->
        <link href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

        <style>
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin: auto;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        </style>

    </head>
    <body style="background: #F2F2F2">
        <div class="container">
            <form id="fileUploadForm" action="/submit" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card card-default m-3">
                    <div class="row m-4">
                        <div class="col-md-10"><input id="file" type="file" name="file" class="dropify" data-allowed-file-extensions="csv" required /></div>
                        <div class="col-md-2"><button id="uploadButton" type="submit" class="btn btn-default">Upload File</button></div>
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

        <!-- Modal -->
        <div class="modal" id="disableOverlayModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="loader"></div>
            </div>
        </div>
        <input type="text" id="tableContent" hidden>

    </body>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready( function () {

            /* OBJECT FORMAT
            var jsonData = [{
                    "created_at": 1,
                    "file_name": 1,
                    "status": 1
                },
                {
                    "created_at": 2,
                    "file_name": 2,
                    "status": 2
                }];
            */

            $('#datatable').DataTable({
                "paging": false,
                "searching": false,
                //"data": [],
                "ajax": {
                    "url": "{{ route('api.getFileList') }}",
                    "type": "GET",
                    "dataSrc": "",
                },
                "columns": [
                    { "data": "created_at" },
                    { "data": "file_name" },
                    { "data": "status" }
                ],
                "order": []
            });

            $('.dropify').dropify({
                messages: {
                    'default': 'Select file/Drag and drop',
                    'replace': 'Select file/Drag and drop to replace',
                    'remove':  'Remove',
                    'error':   'Ooops, something wrong happended.'
                }
            });

            $('#fileUploadForm').ajaxForm({
                beforeSend: function () {
                    var percentage = '0';
                    $('#progressDiv').css("display", "block");
                    $('#uploadButton').prop("disabled",true);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage+'%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                    $('#disableOverlayModal').modal('show');
                },
                complete: function (xhr) {
                    $('#progressDiv').css("display", "none");
                    $('#file').parent().find(".dropify-clear").trigger('click');
                    $('#uploadButton').prop("disabled",false);
                }
            });

            pollServer();
        });

        function pollServer()
        {
            window.setTimeout(function () {
                $.ajax({
                    url: "{{ route('api.getFileList') }}",
                    type: "GET",
                    success: function (result) {
                        //SUCCESS LOGIC
                        $('#datatable').dataTable().fnClearTable();
                        if(!result.length == 0){
                            $('#datatable').dataTable().fnAddData(result);
                        }
                        
                        $('#disableOverlayModal').modal('hide');
                        pollServer();
                    },
                    error: function () {
                        //ERROR HANDLING
                        pollServer();
                    }});
            }, 2000);
        }
    </script>
</html>