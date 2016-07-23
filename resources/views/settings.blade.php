@extends('master')

@section('metas')
<title>Settings</title>
@endsection

@section('content')

	<div class="col-md-12">

		<p class="text-right"><a href="{{ route('settings.add') }}" class="btn btn-info">Add</a></p>

		<table class="table table-striped table-bordered table-hover table-responsive">

			<tr>
				<th>Site</th>
				<th>Class</th>
				<th>Name</th>
				<th>Action</th>
			</tr>

			@foreach($vars['settings']['all'] as $item)
			<tr>
				<td>{{ $item['site_name'] }}</td>
				<td>{{ $item['class'] }}</td>
				<td>{{ $item['name'] }}</td>
				<td><a href="{{ route('settings.edit', ['id' => $item['setting_id']]) }}">Edit</a></td>
			</tr>
			@endforeach

		</table>

		{!! $vars['settings']['paginate'] !!}

	</div>

@endsection