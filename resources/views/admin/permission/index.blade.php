@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#">首页</a></li>
        <li class="active">权限列表</li>
    </ol>

@endsection
@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_panel">
            <div class="x_title">
                <h2>权限列表 </h2>

                <div class="pull-right">
                    <a href="{{url('manage/permission/create')}}" class="btn btn-sm btn-success">添加权限</a>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>权限名称</th>
                        <th>权限变量名</th>
                        <th>超链接</th>
                        <th>上级权限</th>
                        <th>排序</th>
                        <th>是否显示</th>
                        <th>超级管理员专用</th>

                        <th ><span class="nobr">操作</span></th>

                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($permissions as $permission)
                        <tr id="tr_{{$permission->id}}">
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->slug}}</td>
                            <td >{{$permission->url}}</td>
                            <td >{{$permission->parent_name}}</td>
                            <td >{{$permission->sort_order}}</td>
                            <td><i class="fa fa-{{ $permission->is_show==1?'check green':'close red'}} cyesno" onclick="choose_yesno(this,'{{url('manage/permission/'.$permission->id)}}','is_show','{{csrf_token()}}');"/></td>
                            <td><i class="fa fa-{{ $permission->is_admin==1?'check green':'close red'}} cyesno" onclick="choose_yesno(this,'{{url('manage/permission/'.$permission->id)}}','is_admin','{{csrf_token()}}');"/></td>
                            <td>
                                @level(100)
                                <a href="{{url('manage/permission/'.$permission->id."/edit")}}" class="btn btn-info btn-xs"  role="button"><i class="fa fa-pencil"></i> 编辑</a>
                                <a class="btn btn-danger btn-xs" role="button" onclick="delete_record('你确定要删除此记录？','{{url('manage/permission/'.$permission->id)}}','{{csrf_token()}}')" ><i class="fa fa-trash-o"></i> 删除</a>
                                @endlevel
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" align="center">暂无数据</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
            <div>
                @if($permissions->total()>1)
                    {!! $permissions->appends(['keyword'=>$input['keyword']])->links() !!}
                    <div class="clear"></div>
                @endif
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

@endsection