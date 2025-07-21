@extends('emails.master')
@section('content')
<h1 style="font-size: 35px; font-weight: 700; text-align: center; text-transform: capitalize; color: #6103D0; font-family: 'Arimo';" >OMG.ID</h1>
<p  style="font-family: 'Arimo'; text-align: center; font-size: 18px; font-weight: normal; margin: 0; margin-bottom: 10px" > Your Payout Account was Approved! </p>
<table cellspacing="1" cellpadding="1" border="0" width="100%" style="width: 100% !important;">
	<tr>
		<td width="200" align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> Channel Code </td>
		<td align="left" bgcolor="#eeeeee" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> {{$data['channel_code']}} </td>
	</tr>
	<tr>
		<td width="200" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> Account Name </td>
		<td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> {{$data['account_name']}} </td>
	</tr>
	<tr>
		<td width="200" align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> Account Number </td>
		<td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> {{$data['account_number']}} </td>
	</tr>
</table>
@endsection