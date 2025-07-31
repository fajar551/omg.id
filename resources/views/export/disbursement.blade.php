<table>
    <thead>
        <tr>
            <th>Creator Name</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Fee</th>
            <th>Status</th>
            <th>Channel Code</th>
            <th>Account Name</th>
            <th>Account Number</th>
            <th>Account Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt)
            <tr>
                <td>{{ $dt['creator_name'] }}</td>
                <td>{{ $dt['date'] }}</td>
                <td>{{ $dt['payout_amount'] }}</td>
                <td>{{ $dt['payout_fee'] }}</td>
                <td>{{ $dt['status'] }}</td>
                <td>{{ $dt['channel_code'] }}</td>
                <td>{{ $dt['account_name'] }}</td>
                <td>{{ $dt['account_number'] }}</td>
                <td>{{ $dt['type'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>