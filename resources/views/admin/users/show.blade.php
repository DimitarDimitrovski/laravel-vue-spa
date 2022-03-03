@extends('admin.master')
@section('page-title', "$user->name's details")
@section('content')
<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="bg-white p-4">
            <img src="{{ asset('/storage/avatars') }}/{{$user->image }}"
                 width="100" height="100" class="rounded-circle me-3" />
            <div style="display: inline-block; vertical-align: middle;" class="details">
                <h4>{{ $user->name }}</h4>
                <strong>{{ $user->city }}</strong>
                <p>{{ $user->description }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="bg-white p-4">
            <i style="font-size: 50px; vertical-align: middle" class="fas fa-cookie-bite text-primary me-3"></i>
            <div style="display: inline-block; vertical-align: middle;" class="details">
                <h4>Recipes</h4>
                <h5>Count: {{ $user->recipes_count }}</h5>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="bg-white p-4">
            <i style="font-size: 50px; vertical-align: middle" class="fa fa-star text-primary me-3"></i>
            <div style="display: inline-block; vertical-align: middle;" class="details">
                <h4>Reviews</h4>
                <h5>Count: {{ $user->reviews_count }}</h5>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="bg-white p-4">
            <i style="font-size: 50px; vertical-align: middle" class="fa fa-comment text-primary me-3"></i>
            <div style="display: inline-block; vertical-align: middle;" class="details">
                <h4>Comments</h4>
                <h5>Count: {{ $user->comments_count }}</h5>
            </div>
        </div>
    </div>
    <div class="col-12 bg-white p-4 mt-4">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#recipes"
                        type="button" role="tab" aria-controls="recipes" aria-selected="true">Recipes</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button"
                        role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button"
                        role="tab" aria-controls="comments" aria-selected="false">Comments</button>
            </li>
        </ul>
        <div class="tab-content p-3">
            <div class="tab-pane fade show active" id="recipes" role="tabpanel" aria-labelledby="recipes-tab">
                @include('admin.users.fragments.recipes-table')
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                @include('admin.users.fragments.reviews-table')
            </div>
            <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                @include('admin.users.fragments.comments-table')
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/data-table/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let recipes = $('#recipesTable').DataTable();
            let reviews = $('#reviewsTable').DataTable();
            let comments = $('#commentsTable').DataTable();
        })
    </script>
@endpush
