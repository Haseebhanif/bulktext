@component('mail::message')
    {{ __($paymentRecord->credits.' Credits have been added the department '. $paymentRecord->team->name.'!') }}
@endcomponent
