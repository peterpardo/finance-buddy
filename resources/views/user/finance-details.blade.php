@extends('templates.main')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <h1>{{ $title }}</h1>
</div>
<div class="row w-100">
    <div class="col-md-6 d-flex align-items-center justify-content-center">
        <div class="d-flex justify-content-center mt-5">
            <span
            class="border rounded-circle border-dark"
            style="padding: 150px"
            ></span>
        </div>
    </div>
    <div class="col-md-6 p-0">
        <h3>Categories</h3>
        <div class="d-flex align-items-center justify-content-start">
            <button type="button" class="btn btn-outline-success rounded-pill w-25 mx-2">
                Salary
            </button>
            <button type="button" class="btn btn-outline-success rounded-pill w-25 mx-2">
                Savings
            </button>
            <button type="button" class="btn btn-outline-success rounded-pill w-25 mx-2">
                Allowance
            </button>
        </div>
        <div class="container">
            <h3 class="mt-3">Recent Logs</h3>
            <div class="border border-dark mt-2 rounded">
                <table class="table text-center">
                    <tbody>
                        <tr>
                            <td class="fw-bold">Electric Bill</td>
                            <td class="text-muted">Hirap mag bayad</td>
                            <td class="text-body">March 7, 2022</td>
                            <td class="text-danger">$10.00</td>
                            <td class="text-danger">X</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Savings</td>
                            <td class="text-muted">Ako'y rich kid</td>
                            <td class="text-body">March 7, 2022</td>
                            <td class="text-success">$20.00</td>
                            <td class="text-success">X</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
</div>
@endsection