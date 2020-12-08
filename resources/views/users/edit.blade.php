@extends('layouts.app')
@section('title','Edit User')
@section('content')
    <section class="content-header">
        <h1>
            User
        </h1>
    </section>
    <div class="content">
        {!! Form::model($user, ['method' => 'PUT','route' => ['users.update', $user->id], 'files' => true]) !!}

        @include('users.fields')

        {!! Form::close() !!}
    </div>
@endsection
