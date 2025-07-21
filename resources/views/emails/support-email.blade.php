@extends('emails.master')
@section('content')
{{-- <p>For what reason would it be advisable for me to think about business content? That might be little bit risky to have crew member like them.</p> --}}
 @if ($data['payment_status'] == 'EXPIRED' || $data['payment_status'] == 'expire')
	<h1 style="font-size: 35px; font-weight: 700; text-align: center; text-transform: capitalize; color: #6103D0; font-family: 'HelveticaNeue';" > Your Payment Is Expired! </h1><br>
@elseif ($data['payment_status'] == 'failed' || $data['payment_status'] == 'FAILED')
<h1 style="font-size: 35px; font-weight: 700; text-align: center; text-transform: capitalize; color: #6103D0; font-family: 'HelveticaNeue';" > Your Payment Is Failed! </h1><br>
@elseif ($data['status']==0)
	<h1 style="font-size: 35px; font-weight: 700; text-align: center; text-transform: capitalize; color: #6103D0; font-family: 'HelveticaNeue';" > Complete Your Payment! </h1><br>
@elseif ($data['status']==1)
	<h1 style="font-size: 35px; font-weight: 700; text-align: center; text-transform: capitalize; color: #6103D0; font-family: 'HelveticaNeue';" >
	@if (isset($data['for_creator']))
		You receive a Support!
	@else
		Thank You For Your Support! 
	@endif
</h1><br>
@endif

<table cellspacing="1" cellpadding="1" border="0" width="100%">
	<tr>
		<td width="75%" align="left" bgcolor="#eeeeee"> Order ID # </td>
		<td width="25%" align="left" bgcolor="#eeeeee"> {{$data['order_id']}} </td>
	</tr>
	<tr>
		<td width="75%" align="left"> Payment Status </td>
		<td width="25%" align="left"> {{$data['payment_status']}} </td>
	</tr>
	@if ($data['status']==0)
		<tr>
			<td width="75%" align="left" > Expired At </td>
			<td width="25%" align="left"> {{$data['due_date']}} </td>
		</tr>
	@else
		<tr>
			<td width="75%" align="left"> Paid At </td>
			<td width="25%" align="left"> {{$data['date_paid']}} </td>
		</tr>
	@endif
	<tr>
		<td width="75%" align="left"> Payment Method </td>
		<td width="25%" align="left"> {{$data['payment_method']}} </td>
	</tr>
	@if (isset($data['for_creator']))
		<tr>
			<td width="75%" align="left"> Supporter Name </td>
			<td width="25%" align="left"> {{$data['name']}} </td>
		</tr>
	@else
		<tr>
			<td width="75%" align="left"> Creator Name </td>
			<td width="25%" align="left"> {{$data['creator_name']}} </td>
		</tr>
		
	@endif
	<tr>
		<td width="75%" align="left"> Date</td>
		<td width="25%" align="left"> {{$data['order_time']}} </td>
	</tr>
	@if (isset($data['content_name']))
		<tr>
			<td width="75%" align="left"> Content Name </td>
			<td width="25%" align="left">
				@if (strlen($data['content_name']) > 20)
					{{ substr($data['content_name'], 0, 20).'...' }}
				@else
					{{$data['content_name']}}
				@endif
			</td>
		</tr>
		<tr>
			<td width="75%" align="left"> Start </td>
			<td width="25%" align="left"> {{$data['start']}} </td>
		</tr>
		<tr>
			<td width="75%" align="left"> End </td>
			<td width="25%" align="left"> {{$data['end']}} </td>
		</tr>
	@endif
	<tr>
		<td colspan="2" style="padding-top: 30px;;" >
			<table border="0" style="    border: solid 1px #333;"  cellspacing="1" cellpadding="1" width="100%" align="center">
				<tr>
					<td width="25%" align="left"> Item </td>
					<td width="25%" align="left"> Price </td>
					<td width="25%" align="left"> QTY </td>
					<td width="25%" align="left"> Total </td>
				</tr>
				@foreach ($data['items'] as $item)
					<tr>
						<td width="25%" align="left"> {{$item['item']}} </td>
						<td width="25%" align="left"> {{$item['price']}} </td>
						<td width="25%" align="left"> {{$item['qty']}} </td>
						<td width="25%" align="left"> {{$item['total']}} </td>
					</tr>
				@endforeach
			</table>
		</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td width="75%" align="left"><b>TOTAL</b></td>
		<td width="25%" align="left"><b>{{$data['total']}}</b></td>
	</tr>
</table>

@endsection
