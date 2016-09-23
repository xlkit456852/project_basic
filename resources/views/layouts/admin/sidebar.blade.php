<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li>
                <a href="{{url('manage')}}">
                    <i class="fa fa-home"></i>首页
                </a>
            </li>
            @forelse(session('permission_menu') as $permission_menu)
            <li>
                <a href="@if($permission_menu['url']){{url('manage/'.$permission_menu['url'])}}@else javascript:; @endif">
                    @if($permission_menu['icon'])
                    <i class="{!! $permission_menu['icon'] !!}"></i>
                    @endif
                    {!! $permission_menu['name'] !!} <span class="fa fa-chevron-down"></span>
                </a>
                @if(count($permission_menu['child'])>0)
                <ul class="nav child_menu">
                    @foreach($permission_menu['child'] as $child)
                        @if($child['is_show']==1)
                        <li><a href="@if($child['url']){{url('manage/'.$child['url'])}}@else javascript:; @endif">{!! $child['name'] !!}</a></li>
                        @endif
                    @endforeach
                </ul>
                @endif

            </li>
            @empty
            @endforelse

        </ul>
    </div>


</div>