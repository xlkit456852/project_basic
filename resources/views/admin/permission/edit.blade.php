@extends('layouts.admin')
@section('css')
    <link href="{{asset('admin/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#">首页</a></li>
        <li><a href="{{url('manage/permission')}}">权限列表</a></li>
        <li class="active">编辑权限</li>
    </ol>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>编辑权限 </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="{{url('manage/permission/'.$permission->id)}}" id="edit_form" class="form-horizontal" method="post" role="form" novalidate>
                        {{csrf_field()}}
                        {{method_field('put')}}
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">权限名称 <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="name" name="name" required value="{!! $permission->name !!}" placeholder="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">权限变量名 <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="slug" name="slug" required value="{!! $permission->slug !!}" placeholder="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">上级权限 <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="parent_id">
                                    <option value="0">不选择为顶级权限</option>
                                    @foreach($p_permissions as $p)
                                        <option value="{{$p->id}}" @if($permission->parent_id==$p->id)selected @endif >{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">超链接
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="url" name="url" value="{!! $permission->url !!}" placeholder="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">关联模型
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="model" name="model" value="{!! $permission->model !!}" placeholder="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">图标
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="icon" name="icon" value="{!! $permission->icon !!}" placeholder="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">排序
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="sort_order" name="sort_order" value="{!! $permission->sort_order !!}" placeholder="">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">超级管理员专用
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="flat" name="is_admin" value="1" @if($permission->is_admin==1) checked @endif > 是
                                    </label>
                                    <label>
                                        <input type="radio" class="flat" name="is_admin" value="0" @if($permission->is_admin==0) checked @endif> 否
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">是否显示
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="flat" name="is_show" value="1" @if($permission->is_show==1) checked @endif > 是
                                    </label>
                                    <label>
                                        <input type="radio" class="flat" name="is_show" value="0" @if($permission->is_show==0) checked @endif> 否
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-success">提交编辑</button>
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
    <script src="{{asset('admin/vendors/iCheck/icheck.min.js')}}"></script>

@endsection

@section('js')
    @include('layouts.admin.form_validate')
@endsection