@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

	@if(!empty($vars['site_id']))
	<div class="col-md-12">
		<a href="{{ route('sites.home', ['id' => $vars['site_id']]) }}">{{ $vars['site']->name }} options</a>
		<hr />
	</div>
	@endif

	<div class="col-sm-12">

		<h1>Emails directory</h1>

		@if(!empty($vars['site_id']))
			@if(count($vars['tags']))
			<p class="help-block">Filter: <a class="tag {{ $vars['tag'] == '' ? 'label label-default' : '' }}" href="{{ route('sites.emails.directory',['id' => $vars['site_id']]) }}">All</a>
				@foreach($vars['tags'] as $tag)
					<a class="tag {{ $vars['tag'] == $tag->name ? 'label label-default' : '' }}" href="{{ route('sites.emails.directory',['id' => $vars['site_id'], 'tags' => $tag->name]) }}">{{ $tag->name }}</a>
				@endforeach
			</p>
			@endif
			<p class="text-right"><a href="{{ route('sites.emails.add' , ['id' => $vars['site_id']]) }}" class="btn btn-info">Add</a></p>
		@endif

		<table class="table table-striped table-bordered table-hover table-responsive">

			<tr>
				<th>Email</th>
				<th>Tags</th>
				@if(empty($vars['site_id']))
				<th>Site</th>
				@endif
				<th>Added</th>
			</tr>

			@foreach($vars['emails'] as $item)
			<tr>
				<td>{{ $item->email }}</td>
				<td>
					@foreach($item->tags as $tag)
						@foreach($tag->sites as $site)
							@if (!empty($vars['site_id']) && $site->id == $vars['site_id'])
								[{{ ucfirst($tag->name) }}]
							@elseif (empty($vars['site_id']))
								[{{ ucfirst($tag->name) }}]
							@endif
						@endforeach
					@endforeach
				</td>
				@if(empty($vars['site_id']))
				<td>
					@foreach($item->sites as $site)
					[{{ $site->name }}]
					@endforeach
				</td>
				@endif
				<td>{{ $item->created_at }}</td>
			</tr>
			@endforeach

		</table>

	</div>

@endsection