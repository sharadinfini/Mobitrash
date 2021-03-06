@extends('admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Add New Timeslot
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.timeslot.view') }}"><i class="fa fa-coffee"></i>Timeslot</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">

                    {!! Form::model($timeslot, ['method' => 'post', 'route' => $action , 'class' => 'form-horizontal' ]) !!}
                    <div class="form-group">
                        {!!Form::label('City','Timeslot',['class'=>'col-sm-2 required']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name',null, ["class"=>'form-control' ,"placeholder"=>'Timeslot name', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('Active','Start Time',['class'=>'col-sm-2 optional']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('start_time',null, ["class"=>'form-control timepicker', 'placeholder' => 'Start Time']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('Active','End Time',['class'=>'col-sm-2 optional']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('end_time',null, ["class"=>'form-control timepicker', 'placeholder'=>'End Time']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('Active','Active',['class'=>'col-sm-2 optional']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('is_active',[1 => "Yes", 0 => "No"],null, ["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('Active','Slot Type',['class'=>'col-sm-2 optional']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('type',[0 => "Both", 1 => "Operator Shift", 2 => "User Pickup Time" ],null, ["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Form::hidden('id',null) !!}
                            {!! Form::submit('Submit',["class" => "btn btn-primary"]) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}  
                </div>
            </div>
        </div>
    </div>
</section>

@stop 

@section('myscripts')

<script>

    $("[name='chkAll']").click(function (event) {
        var checkbox = $(this);
        var isChecked = checkbox.is(':checked');
        if (isChecked) {
            $("[name='chk[]']").attr('Checked', 'Checked');
        } else {
            $("[name='chk[]']").removeAttr('Checked');
        }
    });

</script>

@stop