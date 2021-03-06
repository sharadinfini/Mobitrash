@extends('admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Settings
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Settings</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">   
                        @permission('admin.schedule.show')
                        <a href="{!! route('admin.miscellaneous.add') !!}" class="btn btn-default pull-right" type="button">Add New</a> 
                        @endpermission
                    </h3>
                    <div class="box-tools">
                    </div>
                </div>

                @if(!empty(Session::get('message')))
                <div class="alert" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif



                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Value</th>
                                <th>URL Key</th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settings as $set)
                            <tr> 
                                <td>{{$set->id }}</td>
                                <td>{{$set->name }}</td>

                                <td>{{$set->value }}</td>
                                <td>{{$set->url_key }}</td>

                                <td>
                                    @permission('admin.miscellaneous.edit')
                                    <a href="{!! route('admin.miscellaneous.edit',['id'=>$set->id]) !!}" class="label label-success active" ui-toggle-class="">Edit</a>
                                    @endpermission
                                    @permission('admin.miscellaneous.delete')
                                    <a href="{!! route('admin.miscellaneous.delete',['id'=>$set->id]) !!}" class="label label-danger active" ui-toggle-class="" onclick="return confirm('Are you sure you want to continue?')">Delete</a>
                                    @endpermission
                                </td>



                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                    <?php
                    $settings->render();
                    ?>

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 
</section>

@stop

