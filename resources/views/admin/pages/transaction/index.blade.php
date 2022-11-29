@extends('admin.layouts.app')
@section('title')
Transaction Management
@endsection
@section('mainContent')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><i class="fa fa-exchange" aria-hidden="true"></i> Transaction Management</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ route('admin.dashboard') }}">Home</a>
			</li>
			<li class="breadcrumb-item active">
				<span class="label label-success float-right title-color">Transaction Table</span>
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
					<br>
					<div class="clearfix"></div>
					<div class="col-md-12 text-left">
						@foreach ($transaction_balance as $sku)
						<div class="btn btn-primary btn-sm pull-left mb-3 op-btn them balance">
							<i class="icon-plus fa-fw"></i>
							Balance {{$sku->currency}}: {{$sku->balance}}
						</div>
						@endforeach
						<div class="clearfix"></div>
					</div>
					<div class="col-md-12 text-right">
						<a class="btn btn-primary btn-sm pull-right mb-3 op-btn them" href="{{route('admin.transaction.create')}}">
							<i class="fa fa-plus"></i> Add Transaction
						</a>
						<a class="btn btn-primary btn-sm pull-right mb-3 op-btn them Showimport" href="javascript:void(0)" data-id="1"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Import XLSX</a>
						<div class="clearfix"></div>
					</div>
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

<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title pull-left" id="exampleModalLabel1">Transaction Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body testdata">
				<h3>Modal Body</h3>
			</div>
		</div>
	</div>
</div>

<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row">
		<div class="col-lg-4">
			<div class="ibox ">
				<div class="ibox-content">
					<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog importdata"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('styles')
<style type="text/css">
table.dataTable {clear: both; margin-top: 6px !important; margin-bottom: 6px !important; max-width: none !important; border-collapse: separate !important; width: 100% !important;}
.op-btn{margin-right:22px;}
table.dataTable{width:100% !important;}
input, textarea, select, button, meter, progress {height: 2.05rem; width: 75px; display: inline-block; background-color: #FFFFFF; background-image: none; border: 1px solid #e5e6e7; border-radius: 1px; color: inherit; padding: 6px 12px; transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;}
</style>
<link rel="stylesheet" type="text/css"  href="{{ asset('assets/new/jquery.dataTables.min.css') }}" />
<link rel="stylesheet" type="text/css"  href="{{ asset('assets/new/buttons.dataTables.min.css') }}" />
@endsection
@section('scripts')
<script src="{{ asset('assets/new/jszip.min.js') }}"></script>
<script src="{{ asset('assets/new/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/new/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/new/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/new/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/new/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/new/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/new/buttons.print.min.js') }}"></script>
{!! $html->scripts() !!}
<script type="text/javascript">
	$(".select2_demo_1").select2({
		placeholder: "Select Country",
		allowClear: true
	});
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
	$(document).on("click","a.deletetransaction",function(e){
		var row = $(this);
		var id = $(this).attr('data-id');
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this record",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#e69a2a",
			confirmButtonText: "Yes",
			cancelButtonText: "No",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm){
			if (isConfirm) {
				$.ajax({
					url:"{{route('admin.transaction.delete',[''])}}"+"/"+id,
					type: 'post',
					data: {"_token": "{{ csrf_token() }}"
				},
				success:function(msg){
					if(msg.status == 'success'){
					swal({title: "Deleted",text: "Delete Record success",type: "success"},
						function(){ 
							location.reload();
						});
				}else{
					swal("Warning!", msg.message, "warning");
				}
			},
			error:function(){
				swal("Error!", 'Error in delete Record', "error");
			}
		});
			} else {
				swal("Cancelled", "Your Transaction is safe :)", "error");
			}
		});
		return false;
	})

	$(document).on("click","a.Showimport",function(e){
	var row = $(this);
	var id = $(this).attr('data-id');
	$.ajax({
		url:"{{ route('admin.transaction.importshow') }}",
		type: 'get',
		data: {id: id},
		success:function(msg){
			$('.importdata').html(msg);
			$('.inmodal').modal('show');
		},
		error:function(){
			swal("Error!", 'Error in Record Not Show', "error");
		}
	});
});

$(document).on("click",".import_data",function(e){
	var formData = new FormData($('#upload-xls-form')[0]);
	$('.add_xsl_button').attr('disabled','disabled');
	$('.inmodal').modal('hide');
	var row = $(this);
	var id = $(this).attr('data-id');
	swal({
		title: "Are you sure?",
		text: "You want to Upload this record ",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#8cd4f5",
		confirmButtonText: "Yes!",
		cancelButtonText: "No!",
		closeOnConfirm: false,
		closeOnCancel: false
	}, function(isConfirm){
		if (isConfirm) {
			$.ajax({
				url: "{{route('admin.transaction.importdata')}}",
				type: "POST",
				data:formData,
				processData: false,
				contentType: false,
				dataType: "json",
				success:function(result){
					$('.add_xsl_button').removeAttr('disabled');
					if(result.status == 'success'){
						swal({title: "Import",text: "Import Data Record success",type: "success"},
							function(){ 
								location.reload();
							});
					}else if(result.status == 'error'){
						swal({title: "Error!",text: "Not Imported Record Successfully",type: "error"},
							function(){ 
								location.reload();
							});
					}else{
						$('.inmodal').modal('show');
						$('.help-block').css({"display":"block"})
						// alert("in");
						// location.reload();
					}
				},
				error:function(){
					swal("Error!", 'Plz File Format Check', "error");
				}
			});
		} else {
			swal("Cancelled", "Your Status is safe :)", "error");
		}
	});
	return false;
})
</script>
<script type="text/javascript">
	// $(document).on("click","a.Showtransaction",function(e){
	// 	var row = $(this);
	// 	var id = $(this).attr('data-id');
	// 	$.ajax({
	// 		url:"{{ route('admin.transaction.show') }}",
	// 		type: 'get',
	// 		data: {id: id},
	// 		success:function(msg){
	// 			$('.testdata').html(msg);
	// 			$('#basicModal').modal('show');
	// 		},
	// 		error:function(){
	// 			swal("Error!", 'Error in Record Not Show', "error");
	// 		}
	// 	});
	// });

	// $(document).on("change","#changeStatus",function(e){
	// 	var row = $(this);
	// 	var id = $(this).attr('data-id');
	// 	var value = $(this).val();

	// 	swal({
	// 		title: "Are you sure?",
	// 		text: "You want's to update this record status ",
	// 		type: "warning",
	// 		showCancelButton: true,
	// 		confirmButtonColor: "#e69a2a",
	// 		confirmButtonText: "Yes",
	// 		cancelButtonText: "No",
	// 		closeOnConfirm: false,
	// 		closeOnCancel: false
	// 	}, function(isConfirm){
	// 		if (isConfirm) {
	// 			$.ajax({
	// 				url:"{{ route('admin.transaction.change_status','replaceid') }}",
	// 				type: 'post',
	// 				data: {"_method": 'post',
	// 				'id':id,
	// 				'status':value,
	// 				"_token": "{{ csrf_token() }}"
	// 			},
	// 			success:function(msg){
	// 				if(msg.status_code == 200){
	// 					swal("Warning!", msg.message, "warning");
	// 				}else{

	// 					location.reload();
	// 				}
	// 			},
	// 			error:function(){
	// 				swal("Error!", 'Error in updated Record', "error");
	// 			}
	// 		});
	// 		} else {
	// 			location.reload();
	// 		}
	// 	});
	// 	return false;
	// })
</script>
<script type="text/javascript">
	$(document).on('click','#report',function (event) {
		window.LaravelDataTables["dataTableBuilder"].ajax.reload();
	});
</script>
@endsection