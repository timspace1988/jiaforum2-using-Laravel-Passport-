@extends('layouts.app')

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop

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
                    <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>Choose category</option>
                    @foreach ($categories as $value)
                    <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
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

@stop

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

  <script >
    $(document).ready(function(){
        Simditor.locale = 'en-US';
        var editor = new Simditor({
          textarea: $('#editor'),
          upload: {
            url: '{{ route('topics.upload_image') }}',
            params: {
              _token: '{{ csrf_token() }}',
            },
            fileKey: 'upload_file',
            connectionCount: 3,
            leaveConfirm:'Uploading is in progress, are you sure to leave this page?',
          },
          pasteImage: true,
        });
    });
  </script>
@stop
