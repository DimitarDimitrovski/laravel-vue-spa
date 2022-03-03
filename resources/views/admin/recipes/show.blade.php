@extends('admin.master')
@section('page-title', 'Recipe')
@section('content')
<div class="row">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="col-sm-12 col-md-8">
        <div class="bg-white p-4 mb-4">
            <div class="mb-3">
                <label class="form-label">Featured image</label>
                <img style="clear: both; display: block" height="300" src="{{ asset('storage/images/') }}/{{ $recipe->featured_image }}" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name"
                       value="{{ $recipe->name }}" disabled />
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" name="description" id="description" disabled
                          style="resize: none;" rows="6">{{ $recipe->description }}</textarea>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-3">
                    <label class="form-label" for="name">Type</label>
                    <input class="form-control" type="text" name="name" id="name"
                           value="{{ $recipe->type }}" disabled />
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label class="form-label" for="name">Preparation Time</label>
                    <input class="form-control" type="text" name="name" id="name"
                           value="{{ $recipe->preparation_time }}" disabled />
                </div>
                <div class="col-sm-12 col-md-4 mb-3">
                    <label class="form-label" for="name">Preparation Level</label>
                    <input class="form-control" type="text" name="name" id="name"
                           value="{{ $recipe->preparation_level }}" disabled />
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="bg-white p-4 mb-4">
            <label class="form-label">Ingredients</label>
            <ul class="list-group">
                @foreach($recipe->ingredients as $ingredient)
                <li class="list-group-item">
                    {{ $ingredient }}
                </li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white p-4 mt-4">
            <label class="form-label">Additional images</label>
            @if($recipe->additional_images)
            <div class="row row-cols-1 row-cols-lg-2 g-2">
                @foreach($recipe->additional_images as $additionalImage)
                <div class="col">
                    <img src="{{ asset('storage/images/') }}/{{ $additionalImage }}" style="object-fit: cover; width: 100%; height: 100%;" />
                </div>
                @endforeach
            </div>
            @else
            <h4>Recipe does not have additional images.</h4>
            @endif
        </div>
        <div class="bg-white p-4 mt-4">
            <form method="post" class="form" role="form" enctype="multipart/form-data"
                  action="{{ route('admin.recipes.approval', ['id' => $recipe->id]) }}">
                @method('PATCH')
                @csrf
                <div class="mb-3">
                    <label for="approved">Recipe approval</label>
                    <select name="approved" id="approved" class="form-select mb-4">
                        <option value="0" @if($recipe->approved === \App\Models\Recipe::DB_FALSE) selected @endif>Reject</option>
                        <option value="1" @if($recipe->approved === \App\Models\Recipe::DB_TRUE) selected @endif>Approve</option>
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
