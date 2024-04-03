@component('mail::message')
    Hi <b>{{$user->name}}</b>,
    <p>To continue with your account registration,
    Simply click on the button below to verify your email address
    </p>
    <p>
        @component('mail::button', ['url' => url('activate/'.base64_encode($user->id))])
            Verify
        @endcomponent
    </p>
    <p>This will verify your email and officially you will be part of E-Commerce</p>
    <h3>
        E-commerce Website
    </h3>
    <a href="https://e-commerce.com" target="_blank">E-commerce</a>
@endcomponent