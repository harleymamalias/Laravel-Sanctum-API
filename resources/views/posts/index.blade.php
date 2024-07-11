@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Add Post</a>
    </div>
    @if($posts->isEmpty())
        <div class="alert alert-info" role="alert">
            There are no posts yet.
        </div>
    @else
        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->body }}</p>
                    <p class="card-text"><small class="text-muted">Posted by {{ $post->user->name }} on {{ $post->created_at->format('Y-m-d') }}</small></p>
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                <div class="card-footer">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="form-group">
                            <label for="comment">Add a Comment:</label>
                            <textarea name="body" id="comment" class="form-control" rows="2" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Comment</button>
                    </form>
                </div>
                @foreach($post->comments as $comment)
                    <div class="card mt-2">
                        <div class="card-body">
                            <p class="card-text">{{ $comment->body }}</p>
                            <p class="card-text"><small class="text-muted">Commented by {{ $comment->user->name }} on {{ $comment->created_at->format('Y-m-d') }}</small></p>
                            @can('update', $comment)
                                <form action="{{ route('comments.update', $comment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="body" value="{{ $comment->body }}" class="form-control mb-2" required>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </form>
                            @endcan
                            @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
</div>
@endsection
