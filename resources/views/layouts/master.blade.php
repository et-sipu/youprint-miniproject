<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>YoPrint</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

        <!-- Datatable -->
        <link href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" rel="stylesheet">

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

        @yield('content')

        <!-- Modal -->
        <div class="modal" id="disableOverlayModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="loader"></div>
            </div>
        </div>
        <input type="text" id="tableContent" hidden>

    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready( function () {

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
                    { "data": "time" },
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
                    $('.progress .progress-bar').css("width", percentage-5 +'%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                    $('#disableOverlayModal').modal('show');
                },
                complete: function (xhr) {
                    $('#progressDiv').css("display", "none");
                    $('#file').parent().find(".dropify-clear").trigger('click');
                    $('#uploadButton').prop("disabled",false);
                    pollServer(hideModal = true);
                }
            });

            pollServer(hideModal = false);
        });

        function pollServer(hideModal)
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

                        if($('#disableOverlayModal.modal.show').length == 1 && hideModal){
                            $('#disableOverlayModal').modal('hide');
                        }
                        
                        pollServer(hideModal = false);
                    },
                    error: function () {
                        //ERROR HANDLING
                        pollServer(hideModal = false);
                    }});
            }, 2000);
        }
    </script>
</html>