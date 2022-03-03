@extends('admin.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/morris.js-0.5.1/morris.css') }}">
@endpush
@section('page-title', 'Dashboard')
@section('content')
<div class="row clearfix mb-4">
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card p-2 text-center text-secondary mb-3">
            <div class="card-body">
                <i style="font-size: 40px" class="fa fa-user text-primary mb-3"></i>
                <span style="display: block">{{ $widgetData['cooks'] }} Cooks</span>
                <a class="stretched-link" href="{{ route('admin.users.index') }}"></a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card p-2 text-center text-secondary mb-3">
            <div class="card-body">
                <i style="font-size: 40px" class="fas fa-drumstick-bite text-primary mb-3"></i>
                <span style="display: block">{{ $widgetData['recipes'] }} Recipes</span>
                <a class="stretched-link" href="{{ route('admin.recipes.index') }}"></a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card p-2 text-center text-secondary mb-3">
            <div class="card-body">
                <i style="font-size: 40px" class="fa fa-star text-primary mb-3"></i>
                <span style="display: block">{{ $widgetData['ratings'] }} Ratings</span>
                <a class="stretched-link" href="{{ route('admin.reviews.index') }}"></a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
        <div class="card p-2 text-center text-secondary mb-3">
            <div class="card-body">
                <i style="font-size: 40px" class="fa fa-comment text-primary mb-3"></i>
                <span style="display: block">{{ $widgetData['comments'] }} Comments</span>
                <a class="stretched-link" href="{{ route('admin.comments.index') }}"></a>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix mb-4">
    <div class="col-sm-12 col-md-6">
        <div class="bg-white p-3">
            <h4>Registered Users</h4>
            @if(!$userYearly)
            <p>There is no data to show.</p>
            @else
            <div id="myfirstchart" style="height: 300px;"></div>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="bg-white p-3">
            <h4>Yearly Recipes</h4>
            @if(!$recipeData)
            <p>There is no data to show.</p>
            @else
            <div id="yearlyRecipes" style="height: 300px;"></div>
            @endif
        </div>
    </div>
</div>
<div class="row clearfix mb-4">
    <div class="col-sm-12 col-md-6">
        <div class="bg-white p-3">
            <h4>Monthly Comments</h4>
            @if(!$commentData)
            <p>There is no data to show.</p>
            @else
            <div id="monthlyComments" style="height: 300px;"></div>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="bg-white p-3">
            <h4>Review Ratings</h4>
            @if(!$reviewData)
            <p>There is no data to show.</p>
            @else
            <div id="reviewRatings" style="height: 300px;"></div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/raphael-2.3.0/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/morris.js-0.5.1/morris.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let userData = {!! json_encode($userYearly, JSON_HEX_TAG) !!};
            let recipeData = {!! json_encode($recipeData, JSON_HEX_TAG) !!};
            let commentData = {!! json_encode($commentData, JSON_HEX_TAG) !!};
            let reviewData = {!! json_encode($reviewData, JSON_HEX_TAG) !!};
            let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            if(Array.isArray(userData) && userData.length) {
                Morris.Line({
                    element: 'myfirstchart',
                    data: userData,
                    xkey: 'month',
                    xLabelFormat: function (d) {
                        return months[d.getMonth()];
                    },
                    ykeys: ['value'],
                    labels: ['Cooks']
                });
            }

            if(Array.isArray(recipeData) && recipeData.length) {
                Morris.Bar({
                    element: 'yearlyRecipes',
                    data: recipeData,
                    xkey: 'quarter',
                    ykeys: ['easy', 'medium', 'hard'],
                    labels: ['Easy Preparation', 'Medium Preparation', 'Hard Preparation']
                }).on('click', function (i, row) {
                    console.log(i, row);
                });
            }

            if(Array.isArray(commentData) && commentData.length) {
                Morris.Line({
                    element: 'monthlyComments',
                    data: commentData,
                    xkey: 'date',
                    ykeys: ['comments'],
                    labels: ['Comments'],

                });
            }

            if(Array.isArray(reviewData) && reviewData.length) {
                Morris.Donut({
                    element: 'reviewRatings',
                    data: reviewData,
                    backgroundColor: '#ccc',
                    labelColor: '#060',
                    colors: [
                        '#0700c4',
                        '#0000ff',
                        '#0052ff',
                        '#007aff',
                        '#00a4ff'
                    ],
                    formatter: function (x) {
                        return x + "%"
                    }
                });
            }
        })
    </script>
@endpush
