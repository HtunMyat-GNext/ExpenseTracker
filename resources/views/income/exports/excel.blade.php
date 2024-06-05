<table>
    <thead>
        <tr>
            <th>Income Title</th>
            <th>Category</th>
            <th>Date</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($incomes as $income)
            <tr>
                <td>{{ $income->title }}</td>
                <td>{{ $income->category->title }}</td>
                <td>{{ $income->date }}</td>
                <td>{{ $income->amount }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="text-align: center; font-weight: bold;">Total Income</td>
            <td style="font-weight: bold;">{{ $total_amount }}</td>
        </tr>
    </tbody>
</table>
