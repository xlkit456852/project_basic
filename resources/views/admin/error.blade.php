@extends('layouts.admin')

@section('content')
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>提示信息 </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content bs-example-popovers">

                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong> {{$message}}</strong>
                </div>

            </div>
        </div>
    </div>
@endsection