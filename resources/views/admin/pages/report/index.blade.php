@extends('admin.layouts.app')
@section('title')
Report Management
@endsection
@section('mainContent')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><i class="fa fa-file" aria-hidden="true"></i> Report Management</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ route('admin.dashboard') }}">Home</a>
			</li>
			<li class="breadcrumb-item active">
				<span class="label label-success float-right title-color">Report Table</span>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-content">
					<div class="row">
						<div class="col-sm-4 m-b-xs" id="data_1">
							<div class="input-group date">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" class="form-control" name="date" value="">
							</div>
						</div>
						<div class="col-sm-4 m-b-xs">
							{!! Form::text('remitter_name',null,['class' => 'form-control','placeholder' => 'Enter Company Name','id'    => 'remitter_name']) !!}
						</div>
						<div class="col-sm-4 m-b-xs">
							{!! Form::text('bank_account',null,['class' => 'form-control','placeholder' => 'Enter Bank Account','id'    => 'bank_account']) !!}
						</div>
						<div class="col-sm-4 m-b-xs">
							{!! Form::text('amount',null,['class' => 'form-control','placeholder' => 'Enter  Amount','id'    => 'amount']) !!}
						</div>
						<div class="col-sm-4 m-b-xs">
							{!! Form::text('beneficairy_name',null,['class' => 'form-control','placeholder' => 'Enter Beneficairy Name','id'    => 'beneficairy_name']) !!}
						</div>
						<div class="col-sm-4 m-b-xs">
							{!! Form::select('country_id',$country_list,null,['class' => 'select2_demo_1 form-control','placeholder' => 'Enter Country','id'    => 'currency','placeholder'=>'Select Country']) !!}
						</div>
						<div class="col-sm-4 m-b-xs">
							{!! Form::text('client',null,['class' => 'form-control','placeholder' => 'Enter Client','id'    => 'client']) !!}
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-append">
									<button class="btn btn-primary btn-sm" id="report">Filter</button>
								</span>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-12">
						<div class="table-responsive">
							{!! $html->table(['class' => 'table table-striped table-bordered dt-responsive nowrap'], true) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('styles')
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
{!! $html->scripts() !!}
<script type="text/javascript">
	$(document).on('click','#report',function (event) {
		window.LaravelDataTables["dataTableBuilder"].ajax.reload();
	});
</script>
<script>
$(document).ready(function(){
    var mem = $('#data_1 .date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format: "yyyy/mm/dd",
        viewMode: "date", 
        minViewMode: "date"
    });
});
</script>
@endsection