<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Finance Buddy') }}</title>


  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" rel="stylesheet">

  {{-- JS --}}
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" defer>
  </script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  {{-- Navigation Bar --}}
  @if(Auth::user())
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
       
       <img src="{{ asset('image/finance-buddy-logo.png') }}"
            alt="Avatar Logo" style="width: 40px; height: 40px" class="rounded-pill mx-2" />
      <a class="navbar-brand fw-lighter" href="/">Finance Buddy</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mynavbar">
        <ul class="navbar-nav me-auto"></ul>
        {{-- PC PART --}}

        <li class="nav-item dropdown d-flex justify-content-end d-none d-md-flex">
          <img
            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8M3x8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80"
            alt="Avatar Logo" style="width: 40px; height: 40px" class="rounded-pill" />
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">Hello, {{
            Auth::user()->first_name }}
          </a>
          <ul class="dropdown-menu justify-content-end">
            <li><a class="dropdown-item justify-content-end" href="/set-reminder">Payment Reminder</a></li>
            <li><a class="dropdown-item justify-content-end" href="/download-records">Download Records</a></li>
            <li><a class="dropdown-item justify-content-end" href="#">My Account</a></li>
            <li>
              <a href="{{ route('logout') }}" class="dropdown-item"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                @csrf
              </form>
            </li>
          </ul>
        </li>
        {{-- MOBILE PART --}}
        <li class="nav-item d-md-none d-flex">
          <div class="text-end w-100">
            <div class="d-flex justify-content-end w-100">
            </div>
            <a class="nav-link justify-content-end row text-white mx-2 my-2" href="/set-reminder">Payment Reminder</a>
            <a class="nav-link justify-content-end row text-white mx-2 my-2" href="/download-records">Download
              Records</a>
            <a class="nav-link justify-content-end row text-white mx-2 my-2" href="#">My Account</a>
            <a href="{{ route('logout') }}" class="nav-link justify-content-end row text-white mx-2 my-2"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Logout
            </a>
          </div>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
            @csrf
          </form>
        </li>
      </div>
    </div>
  </nav>
  @endif

  {{-- Content --}}
  @yield('content')
</body>

</html>