<!-- begin #header -->
<div id="header" class="header navbar-default">

    <!-- begin navbar-header -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed navbar-toggle-left" data-click="sidebar-minify">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="index.html" class="navbar-brand">
            Активная база
        </a>
    </div>
    <!-- end navbar-header -->

    <!-- begin header-nav -->
    <ul class="navbar-nav navbar-right">
        <li>
            <a href="#" data-toggle="navbar-search" class="icon">
                <i class="material-icons">search</i>
            </a>
        </li>
        <li class="dropdown">
            <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle icon">
                <i class="material-icons">inbox</i>
                <span class="label">0</span>
            </a>
            <ul class="dropdown-menu media-list dropdown-menu-right">
                <li class="dropdown-header">Уведомления (0)</li>
                <li class="text-center width-300 p-b-10">
                    Новых нет
                </li>
            </ul>
        </li>
        <li class="dropdown navbar-user">

            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <span class="d-none d-md-inline">Здравствуйте, <strong>{!! (Auth::user()->lastname ? Auth::user()->lastname.'&nbsp' : '') . Auth::user()->name !!}</strong></span>
                <div class="image image-icon bg-black text-grey-darker">
                    <i class="material-icons">person</i>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right" id="user_head_menu">

                <a href="{{ route('user.profile', ['user'=> Auth::id()]) }}" class="dropdown-item">Мой профиль</a>

                <div class="dropdown-item bg-grey-transparent-1">
                    <div class="d-flex align-items-center">
                        <div class="switcher">
                            <input type="checkbox" name="switcher_checkbox_1" id="switcher_checkbox_1" checked="" value="1">
                            <label for="switcher_checkbox_1"></label>
                        </div>
                        <label for="switcher_checkbox_1" class="d-block my-0 ml-2">Учебный режим</label>

                    </div>

                </div>

                {{--<a href="javascript:;" class="dropdown-item"><span class="badge badge-danger pull-right">2</span> Inbox</a>--}}
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item">Выйти из кабинета</a>
            </div>
        </li>
    </ul>
    <!-- end header navigation right -->

    <div class="search-form">
        <button class="search-btn" type="submit"><i class="material-icons">search</i></button>
        <input type="text" class="form-control" placeholder="Искать в базе" />
        <a href="#" class="close" data-dismiss="navbar-search"><i class="material-icons">close</i></a>
    </div>
</div>
<!-- end #header -->