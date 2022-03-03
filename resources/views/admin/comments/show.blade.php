@extends('admin.master')
@section('page-title', 'View Comment')
@section('content')
    <div class="row">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="col-sm-12 col-md-8">
            <div class="bg-white p-4">
                <div class="mb-4">
                    <strong>Comment Author</strong>
                    <input type="text" class="form-control" value="{{ $comment->User->name }}" disabled />
                </div>
                <div class="mb-4">
                    <strong>Comment Content</strong>
                    <textarea class="form-control" rows="9" style="resize: none" disabled>{{ $comment->content }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="bg-white p-4">
                <form method="post" class="form" role="form" enctype="multipart/form-data"
                      action="{{ route('admin.comments.approval', ['id' => $comment->id]) }}">
                    @method('PATCH')
                    @csrf
                    <div class="mb-3">
                        <label for="approved">Review approval</label>
                        <select name="approved" id="approved" class="form-select mb-4">
                            <option value="0" @if($comment->approved === \App\Models\Review::DB_FALSE) selected @endif>Reject</option>
                            <option value="1" @if($comment->approved === \App\Models\Review::DB_TRUE) selected @endif>Approve</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="message">Message</label>
                        <textarea class="form-control" name="message" id="message" style="resize: none;" rows="6"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
