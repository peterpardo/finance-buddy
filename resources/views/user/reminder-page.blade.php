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
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </symbol>
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                  </svg>
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                <div>
                    Set billing reminders to people you lent money to!
                </div>
              </div>
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
        @if($reminders->count() <= 0) <div class="text-center text-center alert alert-warning">No records yet
    </div>
    @else
    <div class="table-sm-responsive">
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
                        <span span class="d-inline-block alert alert-success fw-bold px-2 py-1 w-100 w-sm-25">Sent</span>
                        @else
                        <span class="d-inline-block alert alert-danger fw-bold px-2 py-1 w-100 w-sm-25">Not Sent</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
</div>
@endsection