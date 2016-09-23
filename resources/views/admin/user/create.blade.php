@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#">首页</a></li>
        <li><a href="{{url('manage/user')}}">管理员列表</a></li>
        <li class="active">添加管理员</li>
    </ol>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>添加管理员 </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="{{url('manage/user')}}" id="edit_form" class="form-horizontal" method="post" role="form" novalidate>
                        {{csrf_field()}}
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">管理员账号 <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" required id="name" name="name" placeholder="{!! old('name') !!}">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">管理员密码 <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" class="form-control" id="password" required name="password" value="{!! old('password') !!}" placeholder="">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">角色 <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" required name="role_id">
                                    @foreach($roles as $r)
                                        <option value="{{$r->id}}" @if(old('role_id')==$r->id)selected @endif >{{$r->name}}</option>
                                    @endforeach
                                </select>
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