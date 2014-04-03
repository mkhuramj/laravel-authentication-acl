@extends('authentication::layouts.base-2cols')

@section('title')
Admin area: edit user
@stop

@section('content')

<div class="row">
    {{-- successful message --}}
    <?php $message = Session::get('message'); ?>
    @if( isset($message) )
    <div class="alert alert-success">{{$message}}</div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
            <div class="col-md-10 col-sm-6 col-xs-6">
                <h3 class="panel-title">{{isset($user->id) ? 'Edit' : 'Create'}} user</h3>
           </div>
            <div class="col-md-2 col-sm-6 col-xs-6">
                <a href="{{URL::action('Jacopo\Authentication\Controllers\UserController@postEditProfile',["user_id" => $user->id])}}" class="btn btn-primary text-right"><i class="fa fa-user"></i> Edit profile</a>
            </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <h4>Login data</h4>
                {{Form::model($user, [ 'url' => URL::action('Jacopo\Authentication\Controllers\UserController@postEditUser')] ) }}
                {{FormField::email(["autocomplete" => "off", "label" => "Email: *"])}}
                <span class="text-danger">{{$errors->first('email')}}</span>
                {{FormField::password(["autocomplete" => "off", "label" => isset($user->id) ? "Change password: " : "Password: "])}}
                <span class="text-danger">{{$errors->first('password')}}</span>
                {{FormField::password_confirmation(["autocomplete" => "off", "label" => isset($user->id) ? "Confirm change password: " : "Confirm password: "])}}
                <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                <div class="form-group">
                    {{Form::label("activated","User active: ")}}
                    {{Form::select('activated', ["1" => "Yes", "0" => "No"], (isset($user->activated) && $user->activated) ? $user->activated : "0", ["class"=> "form-control"] )}}
                </div>
                {{Form::hidden('id')}}
                {{Form::hidden('form_name','user')}}
                <a href="{{URL::action('Jacopo\Authentication\Controllers\UserController@deleteUser',['id' => $user->id, '_token' => csrf_token()])}}" class="btn btn-danger pull-right margin-left-5 delete">Delete user</a>
                {{Form::submit('Save', array("class"=>"btn btn-primary pull-right "))}}
                {{Form::close()}}
                </div>
                <div class="col-md-6">
                    <h4><i class="fa fa-users"></i> Groups</h4>
                    @include('authentication::user.groups')

                    {{-- group permission form --}}
                    <h4><i class="fa fa-lock"></i> Permission</h4>
                    {{-- permissions --}}
                    @include('authentication::user.perm')
                </div>
            </div>
        </div>
</div>
@stop

@section('footer_scripts')
<script>
    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });
</script>
@stop