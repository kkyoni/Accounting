<div class="form-group row {{ $errors->has('category_id') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>CATEGORY NAME</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::select('category_id',$category,null,[
        'class' => 'form-control',
        'id'    => 'category',
        'placeholder'=>'Select Category Name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('category_id') ? "".$errors->first('category_id')."" : '' }} </font>
        </span>
    </div>
</div>
<div class="form-group row {{ $errors->has('sub_category_name') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>SUB CATEGORY NAME</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('sub_category_name',null,[
        'class' => 'form-control',
        'id'    => 'sub_category_name'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('sub_category_name') ? "".$errors->first('sub_category_name')."" : '' }} </font>
        </span>
    </div>
</div>
@section('styles')
@endsection
@section('scripts')
@endsection