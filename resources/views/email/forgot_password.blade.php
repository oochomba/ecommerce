@component('mail::message')
    Hi <b>{{$user->name}}</b>,
    <p>Inorder to reset your account password,
    Simply click on the button below to set a new password.
    </p>
    <p>
        @component('mail::button', ['url' => url('password-reset/'.$user->remember_token)])
            Reset Your Password
        @endcomponent
    </p>
    <p>Incase you have any issues recovering your account, please contact us</p>
    <h3>
        E-commerce Website
    </h3>
    <a href="https://e-commerce.com" target="_blank">E-commerce</a>
@endcomponent