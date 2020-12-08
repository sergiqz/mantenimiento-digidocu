@extends('layouts.app')
@section('title','Profile')
@section('scripts')
    <script>
        $(function () {
            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            }
            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            });
        });
    </script>
    <script>
    function loadPreview(input, id) {
        id = id || '#preview_img';
        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $(id)
                        .attr('src', e.target.result)
                        .width(200)
                        .height(150);
            };
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
@stop
@section('content')
    <section class="content-header" style="margin-bottom: 25px;">
        <h1 class="pull-left">
            Profile
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="true">Profile</a></li>
                        <li class=""><a href="#ch_pwd" data-toggle="tab" aria-expanded="false">Change Password</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            {!! Form::model($profile,['class'=>'form-horizontal','files' => true]) !!}
                            <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                {!! Form::label('name', 'Name:', ['class' => 'control-label col-sm-2']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first("name",'<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('email')?'has-error':''}}">
                                {!! Form::label('email', 'Email:', ['class' => 'control-label col-sm-2']) !!}
                                <div class="col-sm-8">
                                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first("email",'<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('username')?'has-error':''}}">
                                {!! Form::label('username', 'Username:', ['class' => 'control-label col-sm-2']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('username', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first("username",'<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('address')?'has-error':''}}">
                                {!! Form::label('address', 'Address:', ['class' => 'control-label col-sm-2']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('address', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first("address",'<span class="help-block">:message</span>') !!}
                                </div>
                            </div>


                            <div class="form-group {{$errors->has('address')?'has-error':''}}">
                                {!! Form::label('photo', trans('Photo profile').'', ['class' => 'control-label col-sm-2']) !!}
                                <div class="col-sm-8">
                                <input type="file" name="photo" id="photo" onchange="loadPreview(this);" class="form-control">

                                <label for="photo"></label>
                                <img id="preview_img" src="https://www.w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="" width="200" height="150"/>
                                {!! Form::hidden('photo_max_size', 20) !!}
                                {!! Form::hidden('photo_max_width', 40) !!}
                                {!! Form::hidden('photo_max_height', 40) !!}
                                <p class="help-block"></p>
                                @if($errors->has('photo'))
                                    <p class="help-block">
                                        {{ $errors->first('photo') }}
                                    </p>
                                @endif
                                </div>
                         </div>

                            <div class="form-group {{$errors->has('description')?'has-error':''}}">
                                {!! Form::label('description', 'Description(Additional Information):', ['class' => 'control-label col-sm-2']) !!}
                                <div class="col-sm-10">
                                    {!! Form::textarea('description', null, ['class' => 'form-control b-wysihtml5-editor']) !!}
                                    {!! $errors->first("description",'<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <button type="submit" class="btn btn-primary" value="btnprofile" name="btnprofile">
                                        Update Profile
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane" id="ch_pwd">
                            {!! Form::model($profile,['class'=>'form-horizontal']) !!}
                            <div class="form-group {{$errors->has('old_password')?'has-error':''}}">
                                {!! Form::label('old_password', 'Old Password:', ['class' => 'control-label col-sm-2']) !!}
                                <div class="col-sm-8">
                                    {!! Form::password('old_password', ['class' => 'form-control']) !!}
                                    {!! $errors->first("old_password",'<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('new_password')?'has-error':''}}">
                                {!! Form::label('new_password', 'New Password:', ['class' => 'control-label col-sm-2']) !!}
                                <div class="col-sm-8">
                                    {!! Form::password('new_password', ['class' => 'form-control']) !!}
                                    {!! $errors->first("new_password",'<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <button type="submit" class="btn btn-primary" value="btnpass" name="btnpass">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
