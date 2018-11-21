@push('css')
    <link href="../assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
@endpush

@push('js')
    <script src="/assets/plugins/parsley/dist/parsley.js"></script>
    <script src="/assets/plugins/parsley/src/i18n/ru.js"></script>
    <script src="/assets/plugins/highlight/highlight.common.js"></script>
    <script src="/assets/js/demo/render.highlight.js"></script>
@endpush

@push('docready')
    Highlight.init();
@endpush

@include('includes.head', ['body_class'=>'pace-top bg-white'])

@include('includes.loader')

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin register -->
    <div class="register register-with-news-feed">
        <!-- begin news-feed -->
        <div class="news-feed">
            <div class="news-image" style="background-image: url('/images/reg_bg.jpg')"></div>
            <div class="news-caption">
                <h4 class="caption-title"><b>Actybase.</b>ru</h4>
                <p>
                    Создайте свой каталог недвижимости, рассылайте предложения клиентам, ведите историю своих сделок, и многое другое..
                </p>
            </div>
        </div>
        <!-- end news-feed -->
        <!-- begin right-content -->
        <div class="right-content">
            @yield('content')

            <hr/>
            <p class="text-center">
                &copy; Actybase - личная база недвижимости - 2018
            </p>
        </div>
        <!-- end right-content -->
    </div>
    <!-- end register -->
</div>
<!-- end page container -->

@stack('modals')

@include('includes.foot')
