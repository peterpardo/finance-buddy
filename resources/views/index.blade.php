@extends('templates.main')

@section('content')
<div class="container postion-relative">
    <div class="d-flex mt-3 justify-content-center text-center">
      <div class="d-flex flex-column px-5 text-success">
        <h4>$1000</h4>
        <p>Income</p>
      </div>
      <div class="d-flex flex-column px-5 text-danger">
        <h4>$1000</h4>
        <p>Expenses</p>
      </div>
      <div class="d-flex flex-column px-5">
        <h4>$1000</h4>
        <p>Total</p>
      </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
      <a href="/income" class="btn btn-outline-success px-5 mx-5 rounded">
        Income
      </a>
      <a href="/expense" class="btn btn-outline-danger px-5 mx-5 rounded">
        Expenses
      </a>
    </div>

    <div class="d-flex justify-content-center mt-5">
      <span
        class="border rounded-circle border-dark"
        style="padding: 150px"
      ></span>
    </div>

    <h3>Recent Logs</h3>
    <table class="table text-center">
      <thead class="mt-2"></thead>
      <tbody>
        <tr>
          <td class="fw-bold">Electric Bill</td>
          <td class="text-muted">Hirap mag bayad</td>
          <td class="text-body">March 7, 2022</td>
          <td class="text-danger">$10.00</td>
        </tr>
        <tr>
          <td class="fw-bold">Savings</td>
          <td class="text-muted">Ako'y rich kid</td>
          <td class="text-body">March 7, 2022</td>
          <td class="text-success">$20.00</td>
        </tr>
      </tbody>
    </table>

    {{-- Add income/expense button --}}
    <button type="button" class="btn btn-success position-absolute rounded-circle" data-bs-toggle="modal" data-bs-target="#addFinanceModal" style="width:100px; height:100px; bottom: 5rem; right:5rem;  box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;">
        <svg xmlns="http://www.w3.org/2000/svg" style="width:5rem; height:5rem;" class="text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
            <form class="modal-body" id="add-finance-form">
              {{-- Success alert --}}
              <div id="success-alert" class="alert alert-dismissible alert-success d-flex align-items-center fade show d-none" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:2rem; height:2rem;" class="me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                  Record successfully added!
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
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
                    <input type="text" name="category" class="form-control" id="category" placeholder="Ex: Savings, Bills">
                    <span class="invalid-feedback" role="alert"></span>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" name="amount" class="form-control" id="amount" placeholder="Ex: 100">
                    <span class="invalid-feedback" role="alert"></span>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Ex: Earned it from work">
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
<script src="{{ $script }}"></script>

@endsection

