@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

	<div class="col-sm-12">

		<table class="table table-striped table-bordered table-hover table-responsive">

			<tr>
				<th>Tag</th>
				<th>Added</th>
			</tr>

			@foreach($vars['tags'] as $item)
			<tr>
				<td>{{ $item->name }}</td>
				<td>{{ $item->created_at }}</td>
			</tr>
			@endforeach

		</table>

		{!! $vars['tags']->links() !!}

	</div>

@endsection