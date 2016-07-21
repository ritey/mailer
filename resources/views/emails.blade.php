@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

<div class="row">

	<div class="col-sm-12">

		<table class="table table-striped table-bordered table-hover table-responsive">

			<tr>
				<th>Email</th>
				<th>Tags</th>
				<th>Added</th>
			</tr>

			@foreach($vars['emails'] as $item)
			<tr>
				<td>{{ $item->email }}</td>
				<td>
					@foreach($item->tags as $tag)
						[{{ ucfirst($tag->name) }}]
					@endforeach
				</td>
				<td>{{ $item->created_at }}</td>
			</tr>
			@endforeach

		</table>

	</div>

</div>

@endsection