<table>
    <thead>
        <tr>
            <th style="font-weight: bold">No</th>
            <th style="font-weight: bold">Expense Title</th>
            <th style="font-weight: bold">Category</th>
            <th style="font-weight: bold">Date</th>
            <th style="font-weight: bold">Amount</th>
        </tr>
    </thead>
    <tbody>
        @php $index = 1; @endphp
        @foreach ($expenses as $expense)
        <tr>
            <td>{{ $index++ }}</td>
            <td>{{ $expense->name }}</td>
            <td>{{ $expense->category->title }}</td>
            <td>{{ $expense->date }}</td>
            <td>{{ $expense->amount }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold;">Total expense</td>
            <td style="font-weight: bold">{{ $total_amount }}</td>
        </tr>
    </tbody>
</table>