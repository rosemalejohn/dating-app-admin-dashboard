@extends('_layouts.auth')

@section('page_title', '403')
@section('page_description', 'Access forbidden')

@section('stylesheets')
<link href="/assets/pages/css/error.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div class="row">
	<div class="col-md-12 page-404">
		<div class="number">
			 403
		</div>
		<div class="details">
			<h3>Oops! Access forbidden.</h3>
			<p>
			 	You are not allowed to view this page.<br/>
			</p>
		</div>
	</div>
</div>
@stop
