@extends('templates.main')

@section('content')
<form method="POST" action="/send-sms" class="container">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Number</label>
      <input type="text" name="phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Message</label>
      <textarea name="message" class="form-control" id="exampleInputPassword1"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection