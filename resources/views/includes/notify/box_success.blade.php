@if($msg)
    <div class="alert alert-green fade show">
        <span class="close" data-dismiss="alert">×</span>
        <i class="fa fa-check fa-2x pull-left m-r-10"></i>
        <p class="m-b-0">{{ $msg }}</p>
    </div>
@endif