@extends('templates.main')

@section('content')
{{-- User ID --}}
<input type="hidden" id="userID" value="{{ Auth::user()->id }}">

<div class="container mx-auto">
    {{-- Page title --}}
    <div class="container d-flex justify-content-center my-3">
        <h1>{{ $title }}</h1>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="container alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" class="me-2" style="width:2rem;" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                clip-rule="evenodd" />
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
            <h3 class="container">Categories</h3>
            <div class="container d-flex flex-row d-sm-flex flex-sm-col" id="category-container">
                @foreach($categories as $category)
                <div class="d-flex justify-content-center align-items-center border border-success text-center text-success py-1 rounded-pill mx-2 my-1 "
                    style="width:18rem;">
                    {{ $category }}
                </div>
                @endforeach
            </div>

            {{-- Finance Logs --}}
            <div class="container d-flex flex-column justify-content-center ">
                <h3 class="mt-3">Recent Logs</h3>
                <div class="border-left-0 border-right-0 rounded my-3">
                    @if($finances->count() <= 0) <div class="text-center alert alert-warning">No records yet</div>
                @else
                <div class="table-sm-responsive">
                    <table class="table text-center align-middle">
                        <thead></thead>
                        <tbody id="table-body">
                            @foreach($finances as $finance)
                            <tr>
                                <td class="fw-bold">{{ $finance->category }}</td>
                                <td class="text-muted">{{ $finance->description }}</td>
                                <td class="text-body">{{ $finance->updated_at->format('M j, Y (D)') }}</td>
                                @if($finance->type === 'income')
                                <td class="text-success">
                                    ₱{{ number_format($finance->amount, 2) }}
                                </td>
                                @else
                                <td class="text-danger">
                                    ₱{{ number_format($finance->amount, 2) }}
                                </td>
                                @endif
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            More
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item editBtns" data-bs-toggle="modal"
                                                    data-bs-target="#editFinanceModal" href="javascript();"
                                                    data-type="{{ $finance->type }}"
                                                    data-category="{{ $finance->category }}"
                                                    data-description="{{ $finance->description }}"
                                                    data-amount="{{ $finance->amount }}"
                                                    data-finance-id="{{ $finance->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-2 text-info"
                                                        style="width:1rem;" viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                        <path fill-rule="evenodd"
                                                            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form method="POST" action="/delete-finance/{{ $finance->id }}">
                                                    @csrf
                                                    <a href="javascript();" class="dropdown-item"
                                                        onclick="event.preventDefault(); console.log(event.target.parentElement.submit())">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-2 text-danger"
                                                            style="width:1rem;" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Delete
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Edit income/expense modal --}}
    <div class="modal fade" id="editFinanceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Income/Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/edit-finance" class="modal-body" id="edit-finance-form">
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
                    <button type="button" class="btn btn-secondary" id="closeModalBtn"
                        data-bs-dismiss="modal">Close</button>
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