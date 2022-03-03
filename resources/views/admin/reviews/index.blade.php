@extends('admin.master')
@section('page-title', 'User Reviews')
@section('content')
    @include('admin.fragments.delete-popup')
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-reviews-tab" data-bs-toggle="tab" data-bs-target="#active-reviews"
                    type="button" role="tab" aria-controls="active-reviews" aria-selected="true">Active Reviews</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="deleted-reviews-tab" data-bs-toggle="tab" data-bs-target="#deleted-reviews" type="button"
                    role="tab" aria-controls="deleted-reviews" aria-selected="false">Deleted Reviews</button>
        </li>
    </ul>
    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="active-reviews" role="tabpanel" aria-labelledby="active-reviews-tab">
            @include('admin.reviews.fragments.active-reviews')
        </div>
        <div class="tab-pane fade" id="deleted-reviews" role="tabpanel" aria-labelledby="deleted-reviews-tab">
            @include('admin.reviews.fragments.deleted-reviews')
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/data-table/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#activeReviews').DataTable();
            $('#deletedReviews').DataTable();
        })
    </script>
@endpush
