<!DOCTYPE html>
<html>
<head>
	<title>Affilates Home</title>
	<style type="text/css">
		body{
			margin: 0;padding: 0;
			height: 100vh;
			width: 100vw;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		a{
			position: fixed;
			top: 0;
			right: 0;
			margin: 20px;
		}
	</style>
</head>
<body>
	<h1> {{ auth()->guard('affiliate')->user()->email }} </h1>
	<a href=" {{url('affiliate-user/logout')}} ">Log out</a>
</body>
</html>