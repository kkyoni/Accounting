<div class="form-group row {{ $errors->has('payment_name') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>PAYMENT NAME</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('payment_name',null,[
        'class' => 'form-control',
        'id'    => 'payment_name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('payment_name') ? "".$errors->first('payment_name')."" : '' }} </font>
        </span>
    </div>
</div>
@section('styles')
@endsection
@section('scripts')
@endsection