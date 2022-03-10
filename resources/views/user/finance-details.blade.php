@extends('templates.main')

@section('content')
{{-- User ID --}}
<input type="hidden" id="userID" value="{{ Auth::user()->id }}">

<div class="container px-4 m-auto">
{{-- Page title --}}
<div class="container d-flex justify-content-center my-3">
    <h1>{{ $title }}</h1>
</div>

{{-- Success Alert --}}
@if(session('success'))
    <div class="container alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="width:2rem;" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        <div>
            {{ session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

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
        <div class="d-flex flex-wrap align-items-center justify-content-start" id="category-container">
            @foreach($categories as $category)
                <div class="border border-success text-center text-success p-2 rounded-pill mx-2 my-1" style="width:18rem;">
                    {{ $category }}
                </div>
            @endforeach
        </div>

        {{-- Finance Logs --}}
        <div>
            <h3 class="mt-3">Recent Logs</h3>
            <div class="border border-dark rounded my-3">
                <table class="table text-center align-middle">
                    <tbody id="table-body">
                        @foreach($finances as $finance)
                            <tr>
                                <td class="fw-bold">{{ $finance->category }}</td>
                                <td class="text-muted">{{ $finance->description }}</td>
                                <td class="text-body">{{ $finance->created_at->format('M j, Y (D)') }}</td>
                                @if($finance->type === 'income')
                                    <td class="text-success">
                                        ₱{{ $finance->amount }}
                                    </td>
                                @else
                                    <td class="text-danger">
                                        ₱{{ $finance->amount }}
                                    </td>
                                @endif
                                <td>
                                    <form method="POST" action="/delete-finance/{{ $finance->id }}">
                                        @csrf
                                        <button 
                                            type="submit"
                                            class="btn btn-danger">
                                            &times;
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
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
</div>
{{-- JS --}}
@foreach($scripts as $script)
    <script src="{{ $script }}"></script>
@endforeach

@endsection