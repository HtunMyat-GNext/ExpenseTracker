<table>
    <thead>
        <tr>
            <th style="font-weight: bold">No</th>
            <th style="font-weight: bold">Income Title</th>
            <th style="font-weight: bold">Category</th>
            <th style="font-weight: bold">Date</th>
            <th style="font-weight: bold">Amount</th>
        </tr>
    </thead>
    <tbody>
        @php $index = 1; @endphp
        @foreach ($incomes as $income)
            <tr>
                <td>{{ $index++ }}</td>
                <td>{{ $income->title }}</td>
                <td>{{ $income->category->title }}</td>
                <td>{{ $income->date }}</td>
                <td>{{ $income->amount }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold;">Total Income</td>
            <td style="font-weight: bold">{{ $total_amount }}</td>
        </tr>
    </tbody>
</table>
