<!DOCTYPE html>
<html>

<head>
    <style>
        #title {
            text-align: center;
        }

        #income {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #income td,
        #income th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #income tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #income tr:hover {
            background-color: #ddd;
        }

        #income th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>

    <h2 id="title">Your Total Income For {{ date('F, Y') }}</h2>

    <table id="income">
        <tr>
            <th>No</th>
            <th>Income Title</th>
            <th>Income Category</th>
            <th>Date</th>
            <th>Amount</th>
        </tr>
        {{ $i = 1; }}
        @foreach ($incomes as $income)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $income->title }}</td>
                <td>{{ $income->category->title }}</td>
                <td>{{ $income->date }}</td>
                <td style="text-align: right">{{ $income->amount }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold;">Total Income</td>
            <td style="font-weight: bold;text-align: right;">{{ $total_amount }}</td>
        </tr>
        </tbody>
    </table>
</body>

</html>
