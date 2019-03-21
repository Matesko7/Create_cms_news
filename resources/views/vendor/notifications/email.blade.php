@component('mail::message')

Dobrý deň,

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

<p>S pozdravom,<br>
KM účtovnictvo</p>

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang(
    "Ak máte problémy s kliknutím na tlačidlo \":actionText\", skopírujte nižšie uvedenú URL adresu\n".
    'do svojho webového prehliadača: [:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
    ]
)
@endcomponent
@endisset
@endcomponent
