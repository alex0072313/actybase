@include('includes.head')
@include('includes.loader')
<div id="page-container" class="fade">
    <!-- begin error -->
    <div class="error">
        <div class="error-code m-b-10">403</div>
        <div class="error-content">
            <div class="error-message">Доступ к данному разделу ограничен</div>
            <div class="error-desc m-b-30"></div>
            <div>
                <a href="{{ route('home') }}" class="btn btn-green p-l-20 p-r-20">Вернуться на главную</a>
            </div>
        </div>
    </div>
    <!-- end error -->
    @include('includes.scrolltotop')
</div>
@include('includes.foot')