@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-body">
        <h2 class="">
          <i class="far fa-edit"></i>
          @if($topic->id)
            Edit post
          @else
            New Post
          @endif
        </h2>

        <hr>

        @if($topic->id)
          <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          @include('shared._error')

                <div class="form-group">
                	<input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}" placeholder=" Write title here (Minimum 2 characters)" required />
                </div>

                <div class="form-group">
                  <select class="form-control" name="category_id" required>
                    <option value="" hidden disabled selected>Choose category</option>
                    @foreach ($categories as $value)
                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                	<textarea name="body" id="editor" class="form-control" rows="6" placeholder=" Write your post here (Minimum 3 characters)" required>{{ old('body', $topic->body ) }}</textarea>
                </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"> Save</i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection