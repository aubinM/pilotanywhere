@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Bonjour!')
@endif
@endif

{{-- Intro Lines --}}
{{ "Vous recevez cette email car vous avez demandez une réinitialisation de mot de passe pour votre compte." }}



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
{{ "Réinitialisé Mot de passe" }}
@endcomponent
@endisset

{{-- Outro Lines --}}
{{ "Ce lien de réinitialisation expirera dans 60 minutes.\n" }}
{{ "Si vous n'avez pas demander une réinitialisation de mot de passe, aucune autre action est requise.\n" }}
{{"Cordialement, IaaServices."}}




{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Si vous avez des problème avec le bouton \"Réinitialisé Mot de Passe\", copiez et coller l\'URL suivant  \n".
    'dans votre naviguateur : [:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
    ]
)
@endslot
@endisset
@endcomponent
