@extends('layouts.app')

@section('title', $user->name . 's\' account')

@section('content')

<div class="row">
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
      <div class="card">
        <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}">
        <div class="card-body">
          <h5><strong>Description</strong></h5>
          <p>Name: {{ $user->name }}</p>
          <p>{{ $user->introduction }}</p>
          <hr>
          <h5><strong>Register at:</strong></h5>
          <p>{{ $user->created_at->diffForHumans() }}</p>
          <hr>
          <h5><strong>Last active at:</strong></h5>
          <p title="{{ $user->last_active_at }}">{{ $user->last_active_at->diffForHumans() }}</p>
        </div>
      </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
      <div class="card">
        <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
        </div>
      </div>
      <hr>

      {{-- user's post --}}
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="{{ route('users.show', $user->id) }}" class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}">
                {{ $user->id === Auth::id() ? 'Your posts' : 'Posts' }}
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}" class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}">
                {{ $user->id === Auth::id() ? 'Your replies' : 'Replies' }}
              </a>
            </li>
          </ul>
          @if(if_query('tab', 'replies'))
            @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
          @else
            @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
          @endif

        </div>
      </div>
    </div>
</div>
@stop
