@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#">首页</a></li>
        <li><a href="{{url('manage/role')}}">角色列表</a></li>
        <li class="active">添加角色</li>
    </ol>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>添加角色 </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="{{url('manage/role')}}" id="edit_form" class="form-horizontal" method="post" role="form" novalidate>
                        {{csrf_field()}}

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">角色名称 <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" data-validate-length-range="6" id="name" required="required" name="name" value="{!! old('name') !!}" placeholder="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">角色别名 <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="slug" required="required" name="slug" value="{!! old('slug') !!}" placeholder="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">管理员级别 <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" class="form-control" id="level" required="required" name="level" data-validate-minmax="1,{{config('admin.superadmin_level')-1}}" value="{!! old('level') !!}" placeholder="1-99">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">角色描述
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="description" name="description" value="{!! old('description') !!}" placeholder="">
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">提交添加</button>
                                <button type="submit" class="btn btn-primary" onclick="history.go(-1)">返回</button>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('plugin_js')
    <script src="{{asset('admin/vendors/validator/validator.js')}}"></script>
@endsection

@section('js')
    @include('layouts.admin.form_validate')
@endsection