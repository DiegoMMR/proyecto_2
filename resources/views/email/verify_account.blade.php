@component('mail::message')
# Verificar cuenta

Haga Click en el boton para verificar su cuenta

@component('mail::button', ['url' => $email_token])
Verificar
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent