@push('css')
    <link href="/assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
    <link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="/assets/plugins/parsley/dist/parsley.js"></script>
    <script src="/assets/plugins/parsley/src/i18n/ru.js"></script>
    <script src="/assets/plugins/highlight/highlight.common.js"></script>
    <script src="/assets/js/demo/render.highlight.js"></script>
    <script src="/assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
    <script src="/assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
    <script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
@endpush

@push('docready')
    Highlight.init();

    $('#user_head_menu').click(function (e) {
        e.stopPropagation();
    });

    @if(session('gritter'))
        setTimeout(function () {
            $.gritter.add({
                title:"{!! session('gritter.title') !!}",
                text:"{!! session('gritter.msg') !!}",
                @if(session('gritter.img'))
                image:"{!!session('gritter.img') !!}",
                @endif
                sticky: true,
                //time:"",
                //class_name:"gritter-error gritter-light"
            });
        }, 2000);
    @endif

@endpush

@include('includes.head')

@include('includes.loader')

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-with-wide-sidebar">

    @include('includes.header')

    @include('includes.sidebar')

    <!-- begin #content -->
    <div id="content" class="{!! isset($content_class) ? $content_class : 'content' !!}">

        {{ @Breadcrumbs::render() }}

        @include('includes.pagetitle')

        @yield('content')

    </div>
    <!-- end #content -->

    @include('includes.scrolltotop')
</div>
<!-- end page container -->
@include('includes.foot')
