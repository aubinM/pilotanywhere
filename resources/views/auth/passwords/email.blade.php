@extends('includes.body_div')

@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <!-- Nested Row within Card Body -->
    <div class="row">
        <div class="col-lg-12 d-none d-lg-block bg-password-image"></div>
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Mot de passe oublié ?</h1>
                    <p class="mb-4">Entrez votre adresse email et vous recevrez un lien de réinitialisation ! </p>
                </div>
                <form class="user">
                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        {{ __('Envoyé un lien de réinitialisation') }}
                    </button>

                    <hr>
                    <div class="text-center">
                        <a class="btn btn-link" href="{{ route('register') }}">Créer un compte ! </a>
                    </div>
                    <div class="text-center">
                        <a class="btn btn-link" href="{{ route('login') }}">Déjà un compte? Connexion !</a>
                    </div>
            </div>
        </div>
    </div>
</form>
@endsection 
