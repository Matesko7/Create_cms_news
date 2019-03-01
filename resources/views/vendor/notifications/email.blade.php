@component('mail::message')

Dobrý deň,

z Vášho emailu bola podaná žiadosť o zaslanie nového hesla do <a href="http://kmuctovnictvo.sk/">kmuctovnictvo.sk</a>

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

Platnosť odkazu je 60 minút.<br>
<p>Pokiaľ ste o zmenu hesla nežiadali, email prosím ignorujte.</p>

<p>S pozdravom,<br>
KM účtovnictvo</p>

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang(
    "Ak máte problémy s kliknutím na tlačidlo 'Resetovať heslo', skopírujte nižšie uvedenú URL adresu\n".
    'do svojho webového prehliadača: [:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
    ]
)
@endcomponent
@endisset
@endcomponent
