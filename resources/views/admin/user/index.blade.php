@extends('layouts.admin')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#">首页</a></li>
        <li class="active">管理员列表</li>
    </ol>

@endsection
@section('content')

    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_panel">
            <div class="x_title">
                <h2>管理员列表 </h2>

                <div class="pull-right">
                    <a href="{{url('manage/user/create')}}" class="btn btn-sm btn-success">添加管理员</a>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th >编号 </th>
                        <th >管理员名称 </th>
                        <th >角色</th>
                        <th ><span class="nobr">操作</span></th>

                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr id="tr_{{$user->id}}">
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>@if($user->role){{$user->role->name}}@endif</td>
                            <td>
                                @level(100)
                                <a href="{{url('manage/user/'.$user->id."/edit")}}" class="btn btn-info btn-xs"  role="button"><i class="fa fa-pencil"></i> 编辑</a>
                                <a class="btn btn-danger btn-xs" role="button" onclick="delete_record('你确定要删除此记录？','{{url('manage/user/'.$user->id)}}','{{csrf_token()}}')" ><i class="fa fa-trash-o"></i> 删除</a>
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
                @if($users->total()>1)
                    {!! $users->appends(['keyword'=>$input['keyword']])->links() !!}
                    <div class="clear"></div>
                @endif
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

@endsection