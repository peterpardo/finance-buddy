@extends('templates.main')

@section('content')
<div class="container col-sm-12">
    <form method="POST" action="/set-reminder" class="col col-md-6 mx-auto m-3 d-flex justify-content-center">
        @csrf
        <div class="p-5 row border border-light rounded">
            {{-- Success alert --}}
            @if(session('success'))
            <div class="container mt-3 alert alert-dismissible alert-success d-flex align-items-center fade show"
                role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:2rem; height:2rem;" class="me-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <h1 class="fw-bold text-center">Set Reminder</h1>
            <div class="mb-3">
                <h6 class="fw-bold">Debtor's Name</h6>
                <input name="name" class="form-control @error('name') is-invalid @enderror" type="text"
                    value="{{ old('name') }}" />
                @error('name')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <h6 class="fw-bold">Phone Number</h6>
                <input name="phone_number"
                    class="form-control pe-3 rounded-end @error('phone_number') is-invalid @enderror" type="number"
                    placeholder="e.g. 9453175950" value="9453175950" />
                @error('phone_number')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <h6 class="fw-bold">Amount lended</h6>
                <input name="amount" class="form-control @error('amount') is-invalid @enderror" type="number"
                    value="{{ old('amount') }}" />
                @error('amount')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <h6 class="fw-bold">Date</h6>
                <input name="date" class="form-control @error('date') is-invalid @enderror" type="date"
                    value="{{ old('date') }}" />
                @error('date')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 d-flex justify-content-center">
                <button type="submit" class="w-50 text-white btn-lg form-control bg-primary">
                    Set
                </button>
            </div>
        </div>
    </form>

    {{-- Reminder List --}}
    <div class="w-75 m-auto">
        <h3>Reminder List</h3>
        <table class="table text-center">
            <thead class="mt-2"></thead>
            <tbody id="table-body">
                @foreach($reminders as $reminder)
                <tr>
                    <td class="fw-bold">{{ $reminder->name }}</td>
                    <td class="text-muted">{{ $reminder->number }}</td>
                    <td class="text-body">₱{{ $reminder->amount }}</td>
                    <td class="text-body">{{ Carbon\Carbon::parse($reminder->date)->format('M j, Y (D)') }}</td>
                    <td>
                        @if($reminder->sent)
                            <span   span class="d-inline-block text-white bg-success rounded px-2 py-1">Sent</span>
                        @else
                            <span class="d-inline-block text-white bg-danger rounded px-2 py-1">Not Sent</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection