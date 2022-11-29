@extends('admin.layouts.app')
@section('title')
Inward Type Management
@endsection
@section('mainContent')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><i class="fa fa-window-maximize" aria-hidden="true"></i> Inward Management</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ route('admin.dashboard') }}">Home</a>
			</li>
			<li class="breadcrumb-item active">
				<span class="label label-success float-right title-color">Inward Table</span>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-content">
					<div class="col-md-12 text-left">
						@foreach ($transaction_balance as $sku)
						<div class="btn btn-primary btn-sm pull-left mb-3 op-btn them balance">
							<i class="icon-plus fa-fw"></i>
							Balance {{$sku->currency}}: {{$sku->total_inword}}
						</div>
						@endforeach
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
@endsection
@section('styles')
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
{!! $html->scripts() !!}
@endsection