@if(isset($pagetitle) && !empty($pagetitle))
    <!-- begin page-header -->
    <h1 class="page-header">
        {{ $pagetitle }}
        @if(isset($pagetitle_desc) && !empty($pagetitle_desc))
            &nbsp;<small>{{ $pagetitle_desc }}</small>
        @endif
        @yield('page_header_buttons')
    </h1>
    <!-- end page-header -->
@endif