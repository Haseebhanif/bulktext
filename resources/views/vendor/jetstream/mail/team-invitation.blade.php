
@component('mail::message')
{{ __('You have been invited to join the :team department!', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('If you do not have an account, you may create one by clicking the button below. After creating an account, you may click the invitation acceptance button in this email to accept the team invitation:') }}


@component('mail::button', ['url' => $invitation->istld ? "$invitation->domain/invite/register/".\Crypt::encryptString($invitation->team->id)."##$invitation->domain?domain=$invitation->domain&tenant=$invitation->domain" : route('invite.new.user',[$invitation->domain,\Crypt::encryptString($invitation->team->id).'##'.$invitation->domain])])
{{ __('Create Account') }}
@endcomponent

{{ __('If you already have an account, you may accept this invitation by clicking the button below:') }}

@else
{{ __('You may accept this invitation by clicking the button below:') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('Accept Invitation') }}
@endcomponent

{{ __('If you did not expect to receive an invitation to this team, you may discard this email.') }}
@endcomponent
