@extends('_layouts.auth')

@section('page_title', '404')

@section('stylesheets')
<link href="/assets/pages/css/error.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div class="row">
	<div class="col-md-12 page-404">
		<div class="number">
		 	404
		</div>
		<div class="details">
			<h3>Oops! You're lost.</h3>
			<p>
		 		We can not find the page you're looking for.<br/>
			</p>
		</div>
	</div>
</div>
@stop
