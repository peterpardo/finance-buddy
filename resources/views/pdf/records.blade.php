<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Finance Buddy</title>
    <style>
        .title {
            text-align: center;
        }
        .category-title {
            margin: 5px 0 5px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: auto;
        }
        thead {
            font-weight: bold;
            text-align: center;
        }
        thead, tbody, td {
            border: 1px solid black;
            padding: 5px 3px; 
        }
    </style>
</head>
<body>
    <h1 class="title">My Finance Buddy</h1>
    <h2 class="category-title">Income</h2>
    <table>
        <thead>
            <tr>
                <td>Category</td>
                <td>Description</td>
                <td>Created At</td>
                <td>Amount</td>
            </tr>
        </thead>
        <tbody>
            @foreach($incomes as $income)
            <tr>
                <td>{{ $income->category}}</td>
                <td>{{ $income->description }}</td>
                <td>{{ $income->created_at->format('M j, Y (D)') }}</td>
                <td>P{{ $income->amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h2 class="category-title">Expenses</h2>
    <table>
        <thead>
            <tr>
                <td>Category</td>
                <td>Description</td>
                <td>Created At</td>
                <td>Amount</td>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->category}}</td>
                <td>{{ $expense->description }}</td>
                <td>{{ $expense->created_at->format('M j, Y (D)') }}</td>
                <td>P{{ $expense->amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>