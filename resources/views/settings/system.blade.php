@extends('_layouts.auth')

@section('page_title', 'System Settings')

@section('content')
	{!! Breadcrumbs::render('settings:system') !!}

	<system-settings :configs="{{ $configs }}"></system-settings>
@stop
