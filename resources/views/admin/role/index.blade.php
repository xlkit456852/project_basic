@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#">首页</a></li>
        <li class="active">角色列表</li>
    </ol>

@endsection
@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_panel">
            <div class="x_title">
                <h2>角色列表 </h2>

                <div class="pull-right">
                    <a href="{{url('manage/role/create')}}" class="btn btn-sm btn-success">添加角色</a>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>角色名称</th>
                        <th>角色别名</th>
                        <th style="width:300px;">角色描述</th>
                        <th>级别</th>
                        <th ><span class="nobr">操作</span></th>

                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($roles as $role)
                        <tr id="tr_{{$role->id}}">
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td>{{$role->slug}}</td>
                            <td >{{$role->description}}</td>
                            <td >{{$role->level}}</td>
                            <td>
                                @level(100)
                                <a href="{{url('manage/role/'.$role->id."/edit")}}" class="btn btn-info btn-xs"  role="button"><i class="fa fa-pencil"></i> 编辑</a>
                                <a href="{{url('manage/permissionrole/'.$role->id."/edit")}}" class="btn btn-primary btn-xs"  role="button"><i class="fa fa-pencil"></i> 角色权限</a>
                                <a class="btn btn-danger btn-xs" role="button" onclick="delete_record('你确定要删除此记录？','{{url('manage/role/'.$role->id)}}','{{csrf_token()}}')" ><i class="fa fa-trash-o"></i> 删除</a>
                                @endlevel
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" align="center">暂无数据</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
            <div>
                @if($roles->total()>1)
                    {!! $roles->appends(['keyword'=>$input['keyword']])->links() !!}
                    <div class="clear"></div>
                @endif
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

@endsection