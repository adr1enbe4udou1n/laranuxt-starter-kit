@component('mail::message')
# Hello,

You've got a new message :

* Nom : {{ $name }}
* Email : {{ $email }}
* Type : {{ $type }}
* Request limit : {{ $request_limit }}
* Address : {{ $address }}
* City : {{ $city }}
* Postcode : {{ $zip }}
* Phone : {{ $phone }}
* Message : {{ $message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
