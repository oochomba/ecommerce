@component('mail::message')
    {{ $contact->subject }}
    <p>Phone :{{ $contact->phone }}</p>
    <p>Email: {{ $contact->email }}</p>
    <p>{{ $contact->message }}</p>
    <h3>
        {{config('siteconfig.sitename')}}
    </h3>
    <a href="{{env('APP_URL')}}" target="_blank">{{config('siteconfig.sitename')}}</a>
@endcomponent
