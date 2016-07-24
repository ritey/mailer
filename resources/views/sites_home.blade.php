@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

	<div class="col-sm-12">

		<h1>{{ $vars['site']->name }}</h1>

		<p>Your options are:</p>

		<ul>
			<li><a href="{{ route('sites.emails.add' , ['id' => $vars['site_id']]) }}">Add emails</a></li>
			<li><a href="{{ route('sites.emails.send' , ['id' => $vars['site_id']]) }}">Send email</a></li>
			<li><a href="{{ route('sites.emails.directory' , ['id' => $vars['site_id']]) }}">View email directory</a></li>
		</ul>

	</div>

@endsection