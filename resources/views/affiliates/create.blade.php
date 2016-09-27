@extends('_layouts.auth')

@section('page_title', 'Add new affiliate')

@section('stylesheets')

@stop

@section('content')
	{!! Breadcrumbs::render('affiliate:new') !!}

	<affiliate-form></affiliate-form>
@stop
