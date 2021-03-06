@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

	<div class="col-sm-12">

		<p class="text-right"><a href="{{ route('logs.clear') }}" class="btn btn-info">Clear</a></p>

		<table class="table table-striped table-bordered table-hover table-responsive">

			<tr>
				<th>Log</th>
				<th>Added</th>
			</tr>

			@foreach($vars['logs'] as $item)
			<tr>
				<td>{{ $item->value }}</td>
				<td>{{ $item->created_at }}</td>
			</tr>
			@endforeach

		</table>

		{!! $vars['logs']->links() !!}

	</div>

@endsection