@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Небольшая проблема!')
@else
# @lang('Приветствуем!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
С Уважением,<br>{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
    @component('mail::subcopy')
    @lang(
        "Если кнопка \":actionText\" не нажимается, просто скопируйте этот url\n".
        'в адресную строку браузера и перейдите: [:actionURL](:actionURL)',
        [
            'actionText' => $actionText,
            'actionURL' => $actionUrl,
        ]
    )
    @endcomponent
@endisset
@endcomponent
