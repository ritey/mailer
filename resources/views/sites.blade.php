@extends('master')

@section('metas')
<title>Sites</title>
@endsection

@section('content')

	<div class="col-md-12">

		<p class="text-right"><a href="{{ route('sites.add') }}" class="btn btn-info">Add</a></p>

		<table class="table table-striped table-bordered table-hover table-responsive">

			<tr>
				<th>Name</th>
				<th>Action</th>
			</tr>

			@foreach($vars['sites'] as $item)
			<tr>
				<td>{{ $item->name }}</td>
				<td>
					<a href="{{ route('sites.home', ['id' => $item->id]) }}">Enter</a> |
					<a href="{{ route('sites.edit', ['id' => $item->id]) }}">Edit</a> |
					<a href="{{ route('sites.delete', ['id' => $item->id]) }}">Delete</a>
				</td>
			</tr>
			@endforeach

		</table>

	</div>

@endsection