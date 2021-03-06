@extends('admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Add New Assets
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.assets.view') }}"><i class="fa fa-coffee"></i>Assets</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">

                    {!! Form::model($asset, ['method' => 'post', 'route' => $action , 'class' => 'form-horizontal' ]) !!}
                    <div class="form-group">
                        {!!Form::label('type','Asset Type',['class'=>'col-sm-2 required']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('type_id',$types,null, ["class"=>'form-control', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('Name','Name',['class'=>'col-sm-2 required']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name',null, ["class"=>'form-control' ,"placeholder"=>'Asset Name', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('assetno','Asset Number',['class'=>'col-sm-2 required']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('asset_no',null, ["class"=>'form-control' ,"placeholder"=>'Asset No', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>


                    <div class="form-group">
                        {!!Form::label('cities','City',['class'=>'col-sm-2 required']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('city_id',$cities,null, ["class"=>'form-control', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        {!!Form::label('partof','Part Of',['class'=>'col-sm-2 required']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('parent_id',$exassets,null, ["class"=>'form-control', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        {!!Form::label('dop','DOP',['class'=>'col-sm-2 required']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('dop',null, ["class"=>'form-control datepicker', 'placeholder'=>'YYYY-MM-DD', "required"]) !!}
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
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Form::hidden('id',null) !!}
                            {!! Form::hidden('added_by',Auth::id()) !!}
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