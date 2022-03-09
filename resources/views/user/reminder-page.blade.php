@extends('templates.main')

@section('content')
<div class="container col-sm-12">
    <form method="POST" action="/set-reminder" class="m-3 d-flex justify-content-center">
        @csrf
        <div class="p-5 w-50 row border border-light rounded">
            <h1 class="fw-bold text-center">Set Reminder</h1>
            <div class="mb-3">
                <h6 class="fw-bold">Number</h6>
                <input class="form-control" type="number" />
            </div>
            <div class="mb-3">
                <h6 class="fw-bold">Message</h6>
                <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
            </div>
            <div class="mb-3">
                <h6 class="fw-bold">Date & Time</h6>
                <input class="form-control" type="datetime-local" />
            </div>
            <div class="mb-3 d-flex justify-content-center">
                <button type="button" class="w-50 text-white btn-lg form-control bg-primary">
                    Set
                </button>
            </div>
        </div>
    </form>
</div>
@endsection