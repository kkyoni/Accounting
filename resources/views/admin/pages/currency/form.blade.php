<div class="form-group row {{ $errors->has('currency') ? 'has-error' : '' }}">
    <label class="col-sm-3 col-form-label">
        <strong>CURRENCY</strong>
        <span class="text-danger">*</span>
    </label>
    <div class="col-sm-6">
        {!! Form::text('currency',null,[
        'class' => 'form-control',
        'id'    => 'currency'
        ]) !!}
        <span class="help-block">
            <font color="red"> {{ $errors->has('currency') ? "".$errors->first('currency')."" : '' }} </font>
        </span>
    </div>
</div>
@section('styles')
@endsection
@section('scripts')
<link href="{{ asset('assets/admin/js/plugins/iCheck/icheck.min.js')}}" rel="stylesheet">
<script>
$(document).ready(function(){
    var mem = $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        format: "dd/mm/yyyy",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
});
</script>
<script type="text/javascript">
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
</script>
@endsection