@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px; margin-bottom: 100px">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div style="display: inline-block;
  margin-top: 15px;">{{ __('Freelancer Dashboard') }}    </div>
                    <div style="float: right;"><form method="POST" action="{{ route('freelancer.logout') }}" class="nav-link" >
                                @csrf
                                <button type="submit"><i class="fa fa-power-off"></i> {{ __('Logout') }}</button>
                            </form> </div>
</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in as a Freelancer!') }}
                    
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection