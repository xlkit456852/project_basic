@extends('layouts.admin')
@section('css')
    <style>
        .checkbox-inline{font-size:14px;}
        .permission_row{}
        .permission_row .p_permission{float:left;width:15%;}
        .permission_row .c_permission{float:left;width:80%;}
    </style>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#">首页</a></li>
        <li><a href="{{url('manage/role')}}">角色列表</a></li>
        <li class="active">编辑角色</li>
    </ol>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>编辑角色 </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{url('manage/permissionrole/'.$role->id)}}" class="form-horizontal" method="post" role="form" >
                        {{csrf_field()}}
                        {{method_field('put')}}
                        @foreach($permissions as $permission)
                            <div class="permission_row">
                                <div class="checkbox-inline p_permission">
                                    <input type="checkbox" name="permission_list[]" @if($permission->checked==1)checked="checked"@endif onclick="all_box_checked(this,'belongsToPlist{{$permission->id}}')" value="{{$permission->id}}"> {{$permission->name}}
                                </div>
                                <div class="c_permission">
                                    @foreach($permission->child as $child)
                                        <label style="display: inline-block">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="permission_list[]" @if($child->checked==1)checked="checked"@endif class="belongsToPlist{{$permission->id}}" onclick="parent_rights_checked(this);" value="{{$child->id}}"> {{$child->name}}&nbsp;&nbsp;&nbsp;&nbsp;
                                            </label>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="clear"></div>
                            </div>
                        @endforeach


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

@section('js')
    <script>

        function all_box_checked(obj,class_name){
            if(obj.checked){
                $('.'+class_name).each(function(){
                    this.checked = true;
                });
            }
            else{
                $('.'+class_name).each(function(){
                    this.checked = false;
                });
            }
        }

        function parent_rights_checked(obj){
            if(obj.checked){
                var parent_obj = $(obj).parents('.permission_row').find('.p_permission input');
                $(parent_obj).each(function(){
                    this.checked = true;
                });
            }
        }
    </script>
@endsection