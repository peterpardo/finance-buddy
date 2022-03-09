@extends('templates.main')

@section('content')
{{-- User ID --}}
<input type="hidden" id="userID" value="{{ Auth::user()->id }}">

{{-- Page title --}}
<div class="container d-flex justify-content-center my-3">
    <h1>{{ $title }}</h1>
</div>

{{-- Success Alert --}}
<div class="container alert alert-success d-flex align-items-center d-none" id="success-alert" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
        Record Successfully Deleted!
    </div>
</div>

<div class="row w-100">
    {{-- Income/Expense Pie Chart --}}
    <div class="col-md-6 d-flex align-items-center justify-content-center">
        <div class="w-75 mx-auto">
            @if($title === 'My Income' )
                <canvas id="incomeChart"></canvas>
            @else
                <canvas id="expenseChart"></canvas>
            @endif
        </div>
    </div>

    <div class="col-md-6 p-0">
        {{-- Categories --}}
        <h3>Categories</h3>
        <div class="d-flex flex-wrap align-items-center" id="category-container"></div>

        {{-- Finance Logs --}}
        <div>
            <h3 class="mt-3">Recent Logs</h3>
            <div class="border border-dark mt-2 rounded">
                <table class="table text-center align-middle">
                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>
    </div>  

    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This action will permanently delete the record. Are you sure you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalBtn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="delete-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS --}}
@foreach($scripts as $script)
    <script src="{{ $script }}"></script>
@endforeach

@endsection