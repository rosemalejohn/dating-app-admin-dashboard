@if ($breadcrumbs)
	<div class="page-bar">
	    <ul class="page-breadcrumb">
	        @foreach ($breadcrumbs as $breadcrumb)
	            @if (!$breadcrumb->last)
	                <li>
	                	<a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
	                	<i class="fa fa-angle-right"></i>
	                </li>
	            @else
	                <li class="active">{{ $breadcrumb->title }}</li>
	            @endif
	        @endforeach
	    </ul>
	</div>
@endif
