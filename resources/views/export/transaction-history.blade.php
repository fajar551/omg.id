<table>
    <tr>
        <td colspan="3" style="font-size: 15px; font-weight: bold;">Transaction Report</td>
    </tr>
    <tr>
        <td>Date:</td>
        <td>{{ $params['start_at'] . ' s/d ' . $params['end_at']}}</td>
    </tr>
    <tr>
        <td>@lang('form.lbl_type'):</td>
        <td>{{ ucwords($params['type']) }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <thead>
        <tr>
            <th style="font-size: 13px; font-weight: bold;">@lang('form.lbl_number')</th>
            <th style="font-size: 13px; font-weight: bold;" width="20">@lang('form.lbl_type')</th>
            <th style="font-size: 13px; font-weight: bold;" width="40">@lang('form.lbl_fee')</th>
            <th style="font-size: 13px; font-weight: bold;" width="30">@lang('form.lbl_amount_get')</th>
            <th style="font-size: 13px; font-weight: bold;" width="15">@lang('form.lbl_status')</th>
            <th style="font-size: 13px; font-weight: bold;" width="10">@lang('form.lbl_created_at')</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($data as $dt)
            <tr>
                <td style="text-align: left">{{ $loop->iteration }}</td>
                <td>{{ $dt->type == 'PAYMENT' ? 'Support' : 'Disbursement' }}</td>
                <td>{{ $dt->fee }}</td>
                <td>{{ "Rp" . number_format($dt->amount,0,',','.') }}</td>
                <td>
                    @if ($dt->status == "settlement" || $dt->status == "SUCCEEDED")
                        {{ "Success" }}
                    @else
                    {{ ucwords($dt->status) }}
                    @endif
                </td>
                <td>{{ date("d-m-Y H:i", strtotime($dt->created_at)) }}</td>
            </tr>
            @php
                $total += $dt->amount;
            @endphp
        @endforeach
        <tr>
            <td colspan="3" style="text-align: center; font-size: 15px; font-weight: bold;">Total</td>
            <td style="font-size: 15px; font-weight: bold;">@php
                echo "Rp" . number_format($total,0,',','.');
            @endphp</td>
        </tr>
    </tbody>
</table>