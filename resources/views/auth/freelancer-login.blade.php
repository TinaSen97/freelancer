@extends('layouts.app')

@section('content')

<!-- Banner and Breadcrumb -->
<section class="bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
  <div class="py-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
      <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Freelancer Login') }}</li>
          </ol>
        </nav>
      </div>
      <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
        <h1 class="h3 mb-0 text-white">{{ __('Freelancer Login') }}</h1>
      </div>
    </div>
  </div>
</section>

<!-- Login Card -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card border-0 box-shadow">
        <div class="card-body">

            <h2 class="h4 mb-3">{{ __('Login') }}</h2>
       

          {{-- Error messages --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('freelancer.login') }}">
            @csrf

            <div class="input-group-overlay form-group">
              <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="dwg-mail"></i></span></div>
              <input id="email" type="email" class="form-control prepended-form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autofocus>
              @error('email')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="input-group-overlay form-group">
              <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="dwg-locked"></i></span></div>
              <div class="password-toggle">
                <input id="password" type="password" class="form-control prepended-form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required>
                <label class="password-toggle-btn">
                  <input class="custom-control-input" type="checkbox"><i class="dwg-eye password-toggle-indicator"></i>
                  <span class="sr-only">{{ __('Show password') }}</span>
                </label>
                @error('password')
                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            <div class="form-group form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
              </label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <a href="{{ route('freelancer.password.request') }}" class="font-size-sm">{{ __('Forgot Your Password?') }}</a>
              <button type="submit" class="btn btn-primary">
                <i class="dwg-sign-in mr-2 ml-n21"></i>{{ __('Login') }}
              </button>
            </div>

            <div class="text-center mt-4">
              <span>{{ __("Don't have an account?") }}</span>
              <a href="{{ url('/freelancer/register') }}" class="nav-link-inline font-size-sm">{{ __('Sign Up Now') }}</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
