<!DOCTYPE html>
<html>

<head>
    <style>
        #title {
            text-align: center;
        }

        #expense {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #expense td,
        #expense th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #expense tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #expense tr:hover {
            background-color: #ddd;
        }

        #expense th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>

    <h2 id="title">Your Total Expense For {{ $month }} {{ date('Y')}}</h2>

    <table id="expense">
        <tr>
            <th>No</th>
            <th>expense Title</th>
            <th>expense Category</th>
            <th>Date</th>
            <th>Amount</th>
        </tr>
        {{ $i = 1; }}
        @foreach ($expenses as $expense)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $expense->name }}</td>
            <td>{{ $expense->category->title }}</td>
            <td>{{ $expense->date }}</td>
            <td style="text-align: right">{{ $expense->amount }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold;">Total expense</td>
            <td style="font-weight: bold;text-align: right;">{{ $total_amount }}</td>
        </tr>
        </tbody>
    </table>
</body>

</html>