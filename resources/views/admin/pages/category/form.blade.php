<div class="form-group row {{ $errors->has('category_name') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>CATEGORY NAME</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('category_name',null,[
        'class' => 'form-control',
        'id'    => 'category_name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('category_name') ? "".$errors->first('category_name')."" : '' }} </font>
        </span>
    </div>
</div>
@section('styles')
@endsection
@section('scripts')
@endsection