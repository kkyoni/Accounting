<div class="modal-content animated bounceInRight">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<i class="fa fa-file-excel-o modal-icon"></i>
		<h4 class="modal-title">Import Excel</h4>
		<a href="{{ asset('/samplesheet/sample.xlsx') }}" class="font-bold" target="_blank" download> Sample Sheet XLSX <i class="fa fa-download" aria-hidden="true"></i></a>
	</div>
	<div class="modal-body">
		<p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
		{{Form::open(['route'=>'admin.transaction.importdata','id'=>'upload-xls-form','files'=>'true'])}}
		<div class="form-group row {{ $errors->has('type') ? 'has-error' : '' }}">
			<label class="col-sm-3 col-form-label">
				<strong>TYPE</strong>
			</label>
			<div class="col-sm-6">
				{!! Form::select('type',['inward' => 'InWard','outward' => 'OutWard','other' => 'Other','daily_balance_tracker' => 'Daily Balance Tracker'],null,['class' => 'form-control','id'  => 'type',
            	'placeholder'   => 'Select Type']) !!}
            	<span class="help-block" style="display:none;">
            		<font color="red"> Plz Enter The Type Select </font>
            	</span>
            </div>
        </div>
		<div class="form-group">
			<label>Import XLSX</label>
			<input type="file" name="test" class="form-control" style="padding: 3px;">
		</div>
		{{Form::close()}}
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary btn-sm import_data add_xsl_button pull-left" type="submit">Import</button>
	</div>
</div>