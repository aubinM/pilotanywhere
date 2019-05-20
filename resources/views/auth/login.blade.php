@extends('includes.body_div')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <!-- Nested Row within Card Body -->
    <div class="row">

        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-center"> 
                    <img src="/images/Logo4-pret-noir2.png" width="200">
                    <h3 class="h4 text-gray-900 mb-4"></h3>
                </div>

                <div class="form-group">
                    <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{Session::has('login') ? Session::get('login') : old('login') }}" required autocomplete="on" autofocus placeholder="Login">
                    @error('login')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Mot de passe">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" {{ Session::has('login') ? 'checked' : '' }}>
                               <label class="custom-control-label" for="customCheck">{{ __('Se souvenir de moi') }}</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('Connexion') }}
                </button>


                <hr>
                <div class="text-center">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oubliée ?') }}
                    </a>
                    @endif
                </div>
                <div class="text-center">
                    <a class="btn btn-link" href="{{ route('register') }}">Creer un compte</a>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

