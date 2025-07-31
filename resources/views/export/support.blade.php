<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Order ID</th>
            <th>Date</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Gross Amount</th>
            <th>PG Fee</th>
            <th>PG Amount</th>
            <th>Platform  Fee</th>
            <th>Platform Amount</th>
            <th>Creator Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt['creator_name'] }}</td>
                <td>{{ $dt['order_id'] }}</td>
                <td>{{ $dt['date'] }}</td>
                <td>{{ $dt['status'] }}</td>
                <td>{{ $dt['payment_method'] }}</td>
                <td>{{ $dt['gross_amount'] }}</td>
                <td>{{ $dt['pg_fee'] }}</td>
                <td>{{ $dt['pg_amount'] }}</td>
                <td>{{ $dt['platform_fee'] }}</td>
                <td>{{ $dt['platform_amount'] }}</td>
                <td>{{ $dt['creator_amount'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>