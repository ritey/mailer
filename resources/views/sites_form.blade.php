@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

	<div class="col-md-12">

		<form method="post" action="{{ $vars['action'] }}" class="form-horizontal">

			<legend>{{ $vars['legend'] }}</legend>

			{!! csrf_field() !!}
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10 ">
					<input type="text" class="form-control" name="name" id="name" value="{{ $vars['site']->name or '' }}">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label for="enabled">
							<input type="checkbox" name="enabled" id="enabled" value="1" {{ $vars['site']->enabled == 1 ? 'checked' : '' }}>
						Enabled</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</form>

	</div>

@endsection