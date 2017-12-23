@component('mail::message')
Dear {{ $name }}.

Your password is {{ $pass }}.

@component('mail::button', ['url' => ''])
Go Site
@endcomponent

Thank you<br>
{{ config('app.name') }}
@endcomponent
