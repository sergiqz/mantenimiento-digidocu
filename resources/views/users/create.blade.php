@extends('layouts.app')
@section('title','New User')
@section('content')
    <section class="content-header">
        <h1>
            User
        </h1>
    </section>
    <div class="content">

        {!! Form::open(['method' => 'POST','route' => 'users.store', 'files' => true]) !!}

        @include('users.fields')

        {!! Form::close() !!}
    </div>
@endsection
