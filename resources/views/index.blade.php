@extends('templates.main')

@section('content')
{{-- User ID --}}
<input type="hidden" id="userID" value="{{ Auth::user()->id }}">

{{-- Success alert --}}
@if(session('success'))
<div class="container mt-3 alert alert-dismissible alert-success d-flex align-items-center fade show" role="alert">
    <svg xmlns="http://www.w3.org/2000/svg" style="width:2rem; height:2rem;" class="me-2" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <div>
        {{ session('success') }}
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="container postion-relative p-sm-3">
    {{-- Income/Expense/Total --}}
    <div class="d-inline d-md-flex justify-content-center align-items-center text-center">
        <div class="mt-5 mt-md-0 d-flex flex-column px-4 px-sm-5 text-success">
            <h4>₱{{ number_format($totalIncome, 2) }}</h4>
            <p>Income</p>
        </div>
        <div class="d-flex flex-column px-4 px-sm-5 text-danger">
            <h4>₱{{ number_format($totalExpense, 2)}}</h4>
            <p>Expenses</p>
        </div>
        <div class="d-flex flex-column px-4 px-sm-5">
            <h4>₱{{ number_format($totalIncome - $totalExpense, 2) }}</h4>
            <p>Balance</p>
        </div>
    </div>
    <div class="d-flex justify-content-center my-3">
        <a href="/income/{{ Auth::user()->id }}" class="btn btn-outline-success px-5 mx-5 rounded">
            Income
        </a>
        <a href="/expense/{{ Auth::user()->id }}" class="btn btn-outline-danger px-5 mx-5 rounded">
            Expenses
        </a>
    </div>

    {{-- Pie Graphs --}}
    <div id="carouselExampleControls" class="carousel slide col col-md-7 mx-auto mx-auto carousel-dark" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="w-75 w mx-auto">
                    @if($finances->where('type', 'income')->count() <= 0)
                        <div class="d-flex justify-content-center align-items-center text-center fs-6 rounded p-5 w-100" style="height:565px;">
                            <p class="fw-bold fs-5">No records yet</p>
                        </div>
                    @else
                        <canvas id="incomeChart"></canvas>
                    @endif
                </div>
                <div class="text-center">
                    <h5>Income</h5>
                    <p>Pie Chart for your Income</p>
                </div>
            </div>
            <div class="carousel-item">
                <div class="w-75 mx-auto">
                    @if($finances->where('type', 'expense')->count() <= 0)
                        <div class="d-flex justify-content-center align-items-center text-center fs-6 rounded p-5 w-100" style="height:565px;">
                            <p class="fw-bold fs-5">No records yet</p>
                        </div>
                    @else
                        <canvas id="expenseChart"></canvas>
                    @endif
                </div>
                <div class="text-center">
                    <h5>Expenses</h5>
                    <p>Pie Chart for your Expenses</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    {{-- Recent Logs --}}
    <div class="w-75 m-auto">
        <h3>Recent Logs</h3>
        @if($finances->count() <= 0)
            <div class="text-center bg-light fs-6 rounded p-5">No records yet</div>
        @else
            <table class="table text-center">
                <thead class="mt-2"></thead>
                <tbody id="table-body">
                    @foreach($finances as $finance)
                    <tr>
                        <td class="fw-bold">{{ $finance->category }}</td>
                        <td class="text-muted">{{ $finance->description }}</td>
                        <td class="text-body">{{ Carbon\Carbon::parse($finance->updated_at)->format('M j, Y (D)') }}</td>
                        @if($finance->type === 'income')
                        <td class="text-success">
                            ₱{{ number_format($finance->amount, 2) }}
                        </td>
                        @else
                        <td class="text-danger">
                            ₱{{ number_format($finance->amount, 2) }}
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>


    {{-- Add income/expense button --}}
    <button type="button" class="position-fixed btn btn-success position-absolute rounded-circle" data-bs-toggle="modal"
        data-bs-target="#addFinanceModal"
        style="width:55px; height:50px; bottom: 2rem; right:2rem;  box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;">
        <svg xmlns="http://www.w3.org/2000/svg" style="width:2rem; height:2rem;" class="text-white" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
    </button>

    {{-- Add income/expense modal --}}
    <div class="modal fade" id="addFinanceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Income/Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/add-finance" class="modal-body" id="add-finance-form">
                    @csrf
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select" name="type" id="type" aria-label="Default select example">
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" name="category" class="form-control" id="category"
                            placeholder="Ex: Savings, Bills">
                        <span class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" id="amount" placeholder="Ex: 100">
                        <span class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description"
                            class="form-control @error('description') is-invalid @enderror" id="description"
                            placeholder="Ex: Earned it from work">
                        <span class="invalid-feedback" role="alert"></span>
                    </div>
                </form>
                <div class="modal-footer">
                    <a href="javascript();" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                    <button id="submitBtn" class="btn btn-primary">Save changes</button>
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