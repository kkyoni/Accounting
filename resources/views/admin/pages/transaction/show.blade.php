<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th>DATE</th>
			<td>
				@if($transaction->date)
				{{date("d M Y", strtotime($transaction->date))}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>STATUS</th>
			<td>
				@if($transaction->status == "received")
				<span class="label label-primary">RECEIVED</span>
				@elseif($transaction->status == "retrun_fund")
				<span class="label label-default">RETURN FUND</span>
				@elseif($transaction->status == "cancle")
				<span class="label label-danger">CANCEL</span>
				@elseif($transaction->status == "expecting")
				<span class="label label-info">EXPECTING</span>
				@elseif($transaction->status == "paid")
				<span class="label label-success">PAID</span>
				@elseif($transaction->status == "hold")
				<span class="label label-warning">HOLD</span>
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>TYPE</th>
			<td>
				@if($transaction->status == "inward")
				InWard
				@elseif($transaction->status == "outward")
				OutWard
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>CURRENCY</th>
			<td>
				@if(!empty($transaction->currency_list->currency))
				{{$transaction->currency_list->currency}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>AMOUNT</th>
			<td>
				@if(!empty($transaction->amount))
				{{$transaction->amount}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>CLIENT</th>
			<td>
				@if(!empty($transaction->client))
				{{$transaction->client}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>REMITTER NAME</th>
			<td>
				@if(!empty($transaction->remitter_name))
				{{$transaction->remitter_name}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>BENEFICAIRY NAME</th>
			<td>
				@if(!empty($transaction->beneficairy_name))
				{{$transaction->beneficairy_name}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>BANK NAME</th>
			<td>
				@if(!empty($transaction->bank_name))
				{{$transaction->bank_name}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>BANK HOLDER</th>
			<td>
				@if(!empty($transaction->bank_holder))
				{{$transaction->bank_holder}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>BANK ACCOUNT</th>
			<td>
				@if(!empty($transaction->bank_account))
				{{$transaction->bank_account}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>COUNTRY</th>
			<td>
				@if(!empty($transaction->country_list->country_name))
				{{$transaction->country_list->country_name}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>CATEGORY NAME</th>
			<td>
				@if(!empty($transaction->category_list->category_name))
				{{$transaction->category_list->category_name}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>SUB CATEGORY NAME</th>
			<td>
				@if(!empty($transaction->subcategory_list->sub_category_name))
				{{$transaction->subcategory_list->sub_category_name}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>INVOICE NUMBER</th>
			<td>
				@if(!empty($transaction->invoice_number))
				{{$transaction->invoice_number}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>INVOICE STATUS</th>
			<td>
				@if(!empty($transaction->invoice_status))
				{{$transaction->invoice_status}}
				@else
				N/A
				@endif
			</td>
		</tr>
		<tr>
			<th>REMARKS</th>
			<td>
				@if(!empty($transaction->remarks))
				{{$transaction->remarks}}
				@else
				N/A
				@endif
			</td>
		</tr>
	</table>
</div>