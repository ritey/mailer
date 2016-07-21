@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

<div class="row">

	<div class="col-sm-12">

		<ul>
			<li><a href="{{ route('sites.emails.add' , ['id' => $vars['site_id']]) }}">Add emails</a></li>
			<li><a href="{{ route('sites.emails.send' , ['id' => $vars['site_id']]) }}">Send email</a></li>
			<li><a href="{{ route('sites.emails.directory' , ['id' => $vars['site_id']]) }}">View directory</a></li>
		</ul>

	</div>

</div>

@endsection