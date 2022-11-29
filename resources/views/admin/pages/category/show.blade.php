<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th>Date</th>
			<td>{{$transaction->username}}</td>
		</tr>
		<tr>
			<th>Status</th>
			<td>
				@if ($transaction->status == "on_hold") 
                   <span class="label label-warning">On Hold</span>
                @elseif($transaction->status == "pending")
                   <span class="label label-danger">Block</span>
                   @else
                   <span class="label label-success">Success</span>
                @endif
            </td>
		</tr>

		<tr>
			<th>Currency</th>
			<td>{{$transaction->currency_list->currency}}</td>
		</tr>
		
		<tr>
			<th>Amount</th>
			<td>{{$transaction->amount}}</td>
		</tr>
		<tr>
			<th>Client</th>
			<td>{{$transaction->client}}</td>
		</tr>
		<tr>
			<th>Beneficiary Name</th>
			<td>{{$transaction->beneficiaryname}}</td>
		</tr>
		<tr>
			<th>Consignee</th>
			<td>{{$transaction->consignee}}</td>
		</tr>
		<tr>
			<th>Bank</th>
			<td>{{$transaction->bank}}</td>
		</tr>
		
	</table>
</div>