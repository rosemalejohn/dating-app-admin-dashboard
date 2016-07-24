@extends('_layouts.auth')

@section('page_title', 'Chat Lobby')

@section('page_description', 'Currently active sessions')

@section('content')
	{!! Breadcrumbs::render('chat:lobby') !!}

	<chat-lobby :conversations="{{ $conversations }}"></chat-lobby>
@stop
