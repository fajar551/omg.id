@extends('emails.master')
@section('content')
{{-- <p style="font-family: 'Arimo';  font-size: 14px; font-weight: normal; margin-bottom: 15px;"> For what reason would it be advisable for me to think about business content? That might be little bit risky to have crew member like them.</p> --}}
{{-- <h1 style="font-size: 35px; font-weight: 700; text-align: center; text-transform: capitalize; color: #6103D0; font-family: 'Arimo';"  >OMG.ID</h1>
<p  style="font-family: 'Arimo';  font-size: 14px; font-weight: normal; margin-bottom: 15px;" > Disbursement Invoice </p><br> --}}
<h3  style="font-size: 28px; font-weight: 700; text-align: center; text-transform: capitalize; color: #6103D0; font-family: 'Arimo';" >Disbursement Invoice</h3><br>
<table cellspacing="1" cellpadding="1" border="0" width="100%" style="width: 100% !important;">
	<tr>
		<td width="75%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> Payout ID # </td>
		<td width="25%" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> {{$data['external_id']}} </td>
	</tr>
	<tr>
		<td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> Transaction Status </td>
		<td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{ strtoupper($data['status']) }} </td>
	</tr>
	<tr>
		<td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Payout Channel </td>
		<td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> {{$data['payout_channel']}} </td>
	</tr>
	<tr>
		<td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> Payout Name </td>
		<td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{$data['payout_name']}} </td>
	</tr>
	<tr>
		<td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Payout Number</td>
		<td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> {{$data['payout_number']}} </td>
	</tr>
	<tr>
		<td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Date</td>
		<td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> {{$data['created_at']}} </td>
	</tr>
</table>
<table cellspacing="1" cellpadding="1" border="0" width="100%">
	<tr>
		<td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 700; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> Fee </td>
		<td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 700; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> {{$data['fee']}} </td>
	</tr>
	<tr>
		<td width="75%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> Amount </td>
		<td width="25%" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> {{$data['amount']}} </td>
	</tr>
</table>

@endsection
