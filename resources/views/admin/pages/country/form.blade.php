<div class="form-group row {{ $errors->has('country_name') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>COUNTRY NAME</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('country_name',null,[
        'class' => 'form-control',
        'id'    => 'country_name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('country_name') ? "".$errors->first('country_name')."" : '' }} </font>
        </span>
    </div>
</div>
@section('styles')
@endsection
@section('scripts')
@endsection