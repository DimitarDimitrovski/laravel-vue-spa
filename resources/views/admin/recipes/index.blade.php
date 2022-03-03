@extends('admin.master')
@section('page-title', 'Published Recipes')
@section('content')
    @include('admin.fragments.delete-popup')
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-recipes-tab" data-bs-toggle="tab" data-bs-target="#active-recipes"
                    type="button" role="tab" aria-controls="active-recipes" aria-selected="true">Active Recipes</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="deleted-recipes-tab" data-bs-toggle="tab" data-bs-target="#deleted-recipes" type="button"
                    role="tab" aria-controls="deleted-recipes" aria-selected="false">Deleted Recipes</button>
        </li>
    </ul>
    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="active-recipes" role="tabpanel" aria-labelledby="active-recipes-tab">
            @include('admin.recipes.fragments.active-recipes')
        </div>
        <div class="tab-pane fade" id="deleted-recipes" role="tabpanel" aria-labelledby="deleted-recipes-tab">
            @include('admin.recipes.fragments.deleted-recipes')
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/data-table/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#activeRecipes').DataTable();
            $('#deletedRecipes').DataTable();
        })
    </script>
@endpush
