<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentellela Alela! | </title>

    @include('layouts.admin.global_css')
            <!-- Animate.css -->
    <link href="{!! asset('admin/vendors/animate.css/animate.min.css') !!}" rel="stylesheet">

</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <div class="form">
                    <h1>后台登录</h1>
                    <div>
                        <input type="text" id="username" class="form-control" placeholder="用户名" required="" />
                    </div>
                    <div>
                        <input type="password" id="password" class="form-control" placeholder="密码" required="" />
                    </div>
                    <div>
                        <button class="btn btn-default" id="submit"  onclick="handle_login()">登录</button>

                    </div>

                    <div class="clearfix"></div>

                </div>
            </section>
        </div>

    </div>
</div>
<!-- jQuery -->
<script src="{!! asset('admin/vendors/jquery/dist/jquery.min.js') !!}"></script>
<script>
    function handle_login(){
        $('#submit').attr('disabled','disabled');
        var username = $('#username').val();
        var password = $('#password').val();
        if(!username || !password){
            alert('用户名与密码不能为空！');
            $('#submit').removeAttr('disabled');
            return false;
        }
        $.ajax({
            type: "post",
            url : '{{url('manage/login')}}',
            data : {
                name: username,
                password:password,
                _token:'{{csrf_token()}}'
            },
            success : function(data){
                $('#submit').removeAttr('disabled');
                if(data.status==1){
                    location.href=data.url;
                }else{
                    alert(data.info);
                }
            }
        });

    }
</script>
</body>
</html>
