@extends('admin.master')
@section('page-title', 'User Comments')
@section('content')
    @include('admin.fragments.delete-popup')
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-comments-tab" data-bs-toggle="tab" data-bs-target="#active-comments"
                    type="button" role="tab" aria-controls="active-comments" aria-selected="true">Active Comments</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="deleted-comments-tab" data-bs-toggle="tab" data-bs-target="#deleted-comments" type="button"
                    role="tab" aria-controls="deleted-comments" aria-selected="false">Deleted Comments</button>
        </li>
    </ul>
    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="active-comments" role="tabpanel" aria-labelledby="active-comments-tab">
            @include('admin.comments.fragments.active-comments')
        </div>
        <div class="tab-pane fade" id="deleted-comments" role="tabpanel" aria-labelledby="deleted-comments-tab">
            @include('admin.comments.fragments.deleted-comments')
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/data-table/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#activeComments').DataTable();
            $('#deletedComments').DataTable();
        })
    </script>
@endpush
