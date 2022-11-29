<div class="form-group row {{ $errors->has('date') ? 'has-error' : '' }}" id="data_1">
    <label class="col-sm-3 col-form-label font-normal">
        <strong>DATE</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" class="form-control" name="date" value="<?php echo date("Y/m/d") ?>">
        </div>
        <span class="help-block">
            <font color="red"> {{ $errors->has('date') ? "".$errors->first('date')."" : '' }} </font>
        </span>
    </div>
</div>
<div class="form-group row {{ $errors->has('status') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>STATUS</strong>
    </label>
    <div class="col-sm-6 inline-block">
        <div class="i-checks">
            <label>
                {{ Form::radio('status', 'received' ,false,['id'=> 'received']) }} <i></i> Received
            </label>
            <label>
                {{ Form::radio('status', 'retrun_fund' ,false,['id' => 'retrun_fund']) }} <i></i> Retrun Fund
            </label>
            <label>
                {{ Form::radio('status', 'cancle' ,false,['id' => 'cancle']) }} <i></i> Cancle
            </label>
            <label>
                {{ Form::radio('status', 'expecting' ,false,['id' => 'expecting']) }} <i></i> Expecting
            </label>
            <label>
                {{ Form::radio('status', 'paid' ,false,['id' => 'paid']) }} <i></i> Paid
            </label>
            <label>
                {{ Form::radio('status', 'hold' ,false,['id' => 'hold']) }} <i></i> Hold
            </label>
        </div>
        <span class="help-block">
            <font color="red">  {{ $errors->has('status') ? "".$errors->first('status')."" : '' }} </font>
        </span>
    </div>
</div>
@if(@$transaction->type)
<div class="form-group row {{ $errors->has('type') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>TYPE</strong>
    </label>
    <div class="col-sm-6">
        {!! Form::select('type',['inward' => 'InWard','outward' => 'OutWard','other' => 'Other'],null,
        ['class' => 'select2_demo_1 form-control','id'  => 'type',
            'placeholder'   => 'Select Type','disabled']) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('type') ? "".$errors->first('type')."" : '' }} </font>
        </span>
    </div>
</div>
@else
    <div class="form-group row {{ $errors->has('type') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>TYPE</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::select('type',['inward' => 'InWard','outward' => 'OutWard','other' => 'Other'],null,
        ['class' => 'select2_demo_1 form-control','id'  => 'type',
            'placeholder'   => 'Select Type'
            ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('type') ? "".$errors->first('type')."" : '' }} </font>
        </span>
    </div>
</div>
@endif
<div class="form-group row {{ $errors->has('currency_id') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>CURRENCY</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::select('currency_id',$currency_list,null,[
        'class' => 'select2_demo_2 form-control',
        'id'    => 'currency',
        'placeholder'=>'Select currency'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('currency_id') ? "".$errors->first('currency_id')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('amount') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>AMOUNT</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('amount',null,[
        'class' => 'form-control',
        'id'    => 'amount'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('amount') ? "".$errors->first('amount')."" : '' }} </font>
        </span>
    </div>
</div>


<div class="form-group row {{ $errors->has('client') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>CLIENT</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('client',null,[
        'class' => 'form-control',
        'id'    => 'client'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('client') ? "".$errors->first('client')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('remitter_name') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>REMITTER NAME</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('remitter_name',null,[
        'class' => 'form-control',
        'id'    => 'remitter_name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('remitter_name') ? "".$errors->first('remitter_name')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('beneficairy_name') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>BENEFICAIRY NAME</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('beneficairy_name',null,[
        'class' => 'form-control',
        'id'    => 'beneficairy_name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('beneficairy_name') ? "".$errors->first('beneficairy_name')."" : '' }} </font>
        </span>
    </div>
</div>


<div class="form-group row {{ $errors->has('bank_name') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>BANK NAME</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('bank_name',null,[
        'class' => 'form-control',
        'id'    => 'bank_name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('bank_name') ? "".$errors->first('bank_name')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('bank_holder') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>BANK HOLDER</strong>
        <span class="text-danger"></span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('bank_holder',null,[
        'class' => 'form-control',
        'id'    => 'bank_holder'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('bank_holder') ? "".$errors->first('bank_holder')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('bank_account') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>BANK ACCOUNT</strong>
        <span class="text-danger"></span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('bank_account',null,[
        'class' => 'form-control',
        'id'    => 'bank_account'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('bank_account') ? "".$errors->first('bank_account')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('country_id') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>COUNTRY</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::select('country_id',$country_list,null,[
        'class' => 'select2_demo_3 form-control',
        'id'    => 'currency',
        'placeholder'=>'Select Country'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('country_id') ? "".$errors->first('country_id')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('category_id') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>CATEGORY NAME</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::select('category_id',$category,null,[
        'class' => 'select2_demo_4 form-control',
        'id'    => 'category',
        'placeholder'=>'Select Category Name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('category_id') ? "".$errors->first('category_id')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('sub_category_id') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>SUB CATEGORY</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::select('sub_category_id',$sub_category_list,null,[
        'class' => 'select2_demo_5 form-control',
        'id'    => 'sub_category_dropdown',
        'placeholder'=>'Select Sub Category Name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('sub_category_id') ? "".$errors->first('sub_category_id')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('invoice_number') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>INVOICE NUMBER</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('invoice_number',null,[
        'class' => 'form-control',
        'id'    => 'invoice_number'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('invoice_number') ? "".$errors->first('invoice_number')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('invoice_status') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>INVOICE STATUS</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::select('invoice_status',['yes' => 'Yes','no' => 'No'],null,
        ['class' => 'select2_demo_6 form-control','id'  => 'type',
            'placeholder'   => 'Select Invoice Status'
            ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('invoice_status') ? "".$errors->first('invoice_status')."" : '' }} </font>
        </span>
    </div>
</div>

<div class="form-group row {{ $errors->has('remarks') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>REMARKS</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('remarks',null,[
        'class' => 'form-control',
        'id'    => 'remarks'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('remarks') ? "".$errors->first('remarks')."" : '' }} </font>
        </span>
    </div>
</div>
@section('styles')
@endsection
@section('scripts')
<link href="{{ asset('assets/admin/js/plugins/iCheck/icheck.min.js')}}" rel="stylesheet">
<script>
    $(".select2_demo_1").select2({
        placeholder: "Select Type",
        allowClear: true
    });
    $(".select2_demo_2").select2({
        placeholder: "Select Currency",
        allowClear: true
    });
    $(".select2_demo_3").select2({
        placeholder: "Select Country",
        allowClear: true
    });
    $(".select2_demo_4").select2({
        placeholder: "Select Category Name",
        allowClear: true
    });
    $(".select2_demo_5").select2({
        placeholder: "Select Sub Category",
        allowClear: true
    });
    $(".select2_demo_6").select2({
        placeholder: "Select Invoice Status",
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
</script>
<script>
    $(document).ready(function() {
        $('#category').on('change', function() {
            var category_id = this.value;
            // console.log(category_id);
            $("#sub_category_dropdown").html('');
            $.ajax({
                url:"{{ route('admin.transaction.get_sub_category') }}",
                type: "POST",
                data: {
                    category_id: category_id,
                    _token: '{{csrf_token()}}'
                },
                dataType : 'json',
                success: function(result){
                    $('#sub_category_dropdown').html('<option value="">Select Sub Category</option>');
                    $.each(result.sub_category,function(key,value){
                        $("#sub_category_dropdown").append('<option value="'+value.id+'">'+value.sub_category_name+'</option>');
                    });
                }
            });
        });
    });
</script>
@endsection