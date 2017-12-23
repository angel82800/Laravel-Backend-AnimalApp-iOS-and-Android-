@extends('base')

@section('content')
    {{--<h1>@lang('admin.test')</h1>--}}
    {{--<h1>{{__('admin.test')}}</h1>--}}


<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#" style="color: #e8e8e8">Animal Lover DashBoard</a>
        </div>
    </div>
</nav>

<div class="content">

        <div class="row">
            <div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
                <div class="card" id="loginPage">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Log In</h4>
                        <p class="category">Pleae animal</p>
                    </div>
                    <div class="card-content table-responsive">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="/login" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-4 col-md-4">
                                    <h4 align="center">Email</h4>
                                </div>
                                <div class="col-sm-8 col-md-8">
                                    <input type="email" name="email" placeholder="Input Email" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-md-4">
                                    <h4 align="center">Password</h4>
                                </div>
                                <div class="col-sm-8 col-md-8">
                                    <input type="password" name="password" placeholder="Input Password" class="form-control" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-6" align="center">
                                    <button type="submit" class="btn btn-success" id="login">Log in</button>
                                </div>
                                <div class="col-sm-6 col-md-6" align="center">
                                    <button class="btn btn-primary" id="signup">Sign up</button>
                                </div>

                            </div>
                            <div class="row" align="right">
                                <a href="">Forgot Password?</a>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card" id="signupPage">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">Sign Up</h4>
                        <p class="category">Pleae animal</p>
                    </div>
                    <div class="card-content table-responsive">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="/signup" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-4 col-md-4">
                                    <h4 align="center">Name</h4>
                                </div>
                                <div class="col-sm-8 col-md-8">
                                    <input type="text" name="name" placeholder="Input Name" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-md-4">
                                    <h4 align="center">Email</h4>
                                </div>
                                <div class="col-sm-8 col-md-8">
                                    <input type="email" name="email" placeholder="Input Email" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-md-4">
                                    <h4 align="center">Password</h4>
                                </div>
                                <div class="col-sm-8 col-md-8">
                                    <input type="password" name="password" placeholder="Input Password" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-md-4">
                                    <h4 align="center">Location</h4>
                                </div>
                                <div class="col-sm-8 col-md-8">
                                    <input type="text" name="location" placeholder="Input Location" class="form-control" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-6" align="center">
                                    <button type="submit" class="btn btn-success">Sign up</button>
                                </div>
                                <div class="col-sm-6 col-md-6" align="center">
                                    <button class="btn btn-default" id="cancel">cancel</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

</div>
<script>
    jQuery(document).ready(function(){
        $("#signupPage").hide();
        $("#signup").click(function () {
            $("#signupPage").show();
            $("#loginPage").hide();
        });
        $("#cancel").click(function () {
            $("#signupPage").hide();
            $("#loginPage").show();
        });
    });
</script>


@endsection