@extends('admin.master')
@section('page-title', 'Registered Cooks')
@section('content')
    @include('admin.fragments.delete-popup')
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-cooks-tab" data-bs-toggle="tab" data-bs-target="#active-cooks"
                    type="button" role="tab" aria-controls="active-cooks" aria-selected="true">Active Cooks</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="deleted-cooks-tab" data-bs-toggle="tab" data-bs-target="#deleted-cooks" type="button"
                    role="tab" aria-controls="deleted-cooks" aria-selected="false">Deleted Cooks</button>
        </li>
    </ul>
    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="active-cooks" role="tabpanel" aria-labelledby="active-cooks-tab">
            @include('admin.users.fragments.active-cooks')
        </div>
        <div class="tab-pane fade" id="deleted-cooks" role="tabpanel" aria-labelledby="deleted-cooks-tab">
            @include('admin.users.fragments.deleted-cooks')
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/data-table/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#activeCooks').DataTable();
            $('#deletedCooks').DataTable();
        })
    </script>
@endpush
