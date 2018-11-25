<!-- begin #sidebar -->
<div id="sidebar" class="sidebar" data-disable-slide-animation="true">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <a href="javascript:;" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>

                    @if(Storage::disk('public')->exists('user_imgs/'.Auth::id().'/thumb_s.jpg'))
                        <div class="image image-icon">
                            <img src="{{ Storage::disk('public')->url('user_imgs/'.Auth::id().'/thumb_s.jpg') }}" alt="">
                        </div>
                    @else
                        <div class="image image-icon bg-black text-grey-darker">
                            <i class="material-icons">person</i>
                        </div>
                    @endif

                    <div class="info">
                        <b class="caret pull-right"></b>
                        {!! (Auth::user()->lastname ? Auth::user()->lastname.'&nbsp' : '') . Auth::user()->name !!}
                        <small>{{ config('role.names.'.Auth::user()->roles()->get()->first()->name.'.dolg') }}</small>
                    </div>
                </a>
            </li>
            <li>
                <ul class="nav nav-profile">
                    <li><a href="{{ route('user.profile', ['user'=> Auth::id()]) }}"><i class="fa fa-pencil-alt"></i> Изменить профиль</a></li>
                </ul>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">

            <li class="active">
                <a href="{{ route('home') }}">
                    <i class="material-icons">home</i>
                    <span>Главная</span>
                </a>
            </li>

            @role('megaroot')
                <li><a href="{{ route('_company_list') }}"><i class="fa fa-briefcase"></i> <span>Компании</span></a></li>
                <li><a href="{{ route('_user_list') }}"><i class="fa fa-users"></i> <span>Пользователи</span></a></li>
            @endrole

            @role('boss')
                <li class="nav-header">Компания</li>
                <li><a href="{{ route('user_company') }}"><i class="fa fa-cog"></i> <span>Управление компанией</span></a></li>
                <li><a href="{{ route('user.list') }}"><i class="fa fa-users"></i> <span>Менеджеры</span></a></li>
            @endrole

            @role('boss|manager')
                <li class="nav-header">База</li>

                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="material-icons">business</i>
                        <span>Обьекты</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="javascript:;">Квартиры</a></li>
                        <li><a href="javascript:;">Студии <small><i class="fa fa-plus text-theme m-l-5"></i></small></a></li>
                        <li><a href="javascript:;">Пентхаусы <small><i class="fa fa-plus text-theme m-l-5"></i></small></a></li>
                        <li><a href="javascript:;">Ком. помещения <small><i class="fa fa-plus text-theme m-l-5"></i></small></a></li>
                        <li><a href="javascript:;">Дома</a></li>
                        <li><a href="javascript:;">Земельные участки</a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="#">
                        <i class="material-icons">contacts</i>
                        <span>Клиенты</span>
                    </a>
                </li>
            @endrole


            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->