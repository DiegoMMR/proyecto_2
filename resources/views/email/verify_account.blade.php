@component('mail::message')
# Verificar cuenta

Bienvenido a nuesto banco {{ $name }} <br>

su password es: {{$password}}

Haga Click en el boton para verificar su cuenta

@component('mail::button', ['url' => $email_token])
Verificar
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent