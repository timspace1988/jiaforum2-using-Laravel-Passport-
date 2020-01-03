@extends('layouts.app')
@section('title', 'No permision to visit')

@section('content')
  <div class="col-md-4 offset-md-4">
    <div class="card">
      <div class="card-body">
        @if(Auth::check())
          <div class="alert alert-danger text-center mb-0">
            Current account has no permission to visit administration page.
          </div>
        @else
          <div class="alert alert-danger text-center">
            Please sign in to continue your operation.
          </div>

          <a href="{{ route('login') }}" class="btn btn-lg btn-primary btn-block">
            <i class="fas fa-sign-in-alt"></i>
            Sign in
          </a>
        @endif
      </div>
    </div>
  </div>
@stop
