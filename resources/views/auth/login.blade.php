@extends('layouts.app')

@section('content')
    <style>
        .err {
            color: red;
            padding-left: 20px;
        }
    </style>
    <div class="container">

        @if(Session::has('failure'))
            <script> Materialize.toast('{{Session::get('failure')}}', 4000) // 4000 is the duration of the toast</script>
        @endif
        @if(Session::has('success'))
            <script> Materialize.toast('{{Session::get('success')}}', 4000) // 4000 is the duration of the toast</script>
        @endif



        <div class="row" id="login-page" style="">
            <div class="col s12 z-depth-1 card-panel">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}"
                      style="padding-left: 15px; padding-right: 19px;">
                    {{csrf_field()}}
                    <div class="row margin" style="padding-top: 30px;">
                        <div class="input-field col s12"><i class="mdi-social-person-outline prefix"></i>
                            <input type="text" id="username" name="username" value="{{ old('username') }}">
                            <label class="center-align" for="username">Username</label>
                            @if ($errors->has('username'))
                                <span class="help-block err">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>
                    <div class="row margin">
                        <div class="input-field col s12"><i class="mdi-action-lock-outline prefix"></i>
                            <input type="password" id="password" name="password" value="">
                            <label for="password">Password</label>
                            @if ($errors->has('password'))
                                <span class="help-block err">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    {{--<div class="row">--}}
                        {{--<div class="input-field col s12 m12 l12  login-text">--}}
                            {{--<input type="checkbox" id="remember-me" name="remember" class="filled-in">--}}
                            {{--<label for="remember-me">Remember me</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="row">
                        <div class="input-field col s12">

                            <button class="btn waves-effect waves-light col s12 lineht30 loginCls" type="submit" name="action">Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
