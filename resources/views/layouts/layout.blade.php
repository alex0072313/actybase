@push('docready')
    $('#user_head_menu').click(function (e) {
        e.stopPropagation();
    });
@endpush

@include('includes.head')

@include('includes.loader')

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-with-wide-sidebar">

    @include('includes.header')

    @include('includes.sidebar')

    <!-- begin #content -->
    <div id="content" class="content">

        {{ @Breadcrumbs::render() }}

        @include('includes.pagetitle', ['pagetitle'=>'Заголовок'])

        @yield('content')

    </div>
    <!-- end #content -->

    @include('includes.scrolltotop')
</div>
<!-- end page container -->
@include('includes.foot')
