<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-
    alpha/css/bootstrap.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

{{-- Flassmessage --}}
<script>
$(function(){
    // 情報更新用message
    @if(Session::has('status'))
        toastr.options =
        {
            "closeButton" : true,
            "positionClass": "toast-top-center",
        }
toastr.success("{{ Session::get('status') }}");
@endif
});
</script>
