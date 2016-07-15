@extends('layouts.auth')

@section('page_title', $user->name)

@section('content')
	{!! Breadcrumbs::render('users:edit', $user) !!}
@stop
