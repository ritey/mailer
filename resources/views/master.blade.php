<html>
<head>
	@yield('metas')
	<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	@yield('head')

</head>
<body>

	<div class="container">

		<div class="row">

			<div class="col-sm-12">
				<hr>
				<a href="/">Home</a> | <a href="{{ route('sites.index') }}">Sites</a> | <a href="{{ route('logs.index') }}">Logs</a> | <a href="{{ route('settings.index') }}">Settings</a>
				<hr>
			</div>

		</div>

		<div class="row">

			@yield('content')

		</div>

	</div>

	<script
			  src="https://code.jquery.com/jquery-2.2.4.min.js"
			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
			  crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>