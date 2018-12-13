@if($notifications->count() > 0)
    <li class="dropdown">
        <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle icon">
            <i class="material-icons">inbox</i>
            <span class="label">{{ $notifications->count() }}</span>
        </a>
        <ul class="dropdown-menu media-list dropdown-menu-right">
            <li class="dropdown-header">Уведомления ({{ $notifications->count() }})</li>
            @foreach($notifications as $notification)
                <li class="media">
                    <a href="javascript:;">
                        <div class="media-body">
                            <h6 class="media-heading">{{ $notification->subject }}
                                @switch($notification->type)
                                    @case (0)
                                        <i class="fa fa-exclamation-circle text-danger"></i>
                                    @break
                                    @case (1)
                                        <i class="fa fa-exclamation-circle text-orange"></i>
                                    @break
                                    @case (2)
                                        <i class="fa fa-exclamation-circle text-success"></i>
                                    @break
                                @endswitch
                            </h6>
                            @if($notification->text)
                                <p>{{ $notification->text }}</p>
                            @endif
                            {{--<div class="text-muted f-s-11">{{ Carbon::create($notification->create_date)->diffForHumans() }}</div>--}}
                            <div class="text-muted f-s-11">{{ Carbon::parse($notification->created_at, 'Europe/Moscow')->diffForHumans() }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endif
