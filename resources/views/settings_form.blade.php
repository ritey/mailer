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
				<label for="class" class="col-sm-2 control-label">Site</label>
				<div class="col-sm-6">
					<select name="site_id" id="site_id" class="form-control">
						@foreach($vars['sites'] as $item)
							@if($vars['setting']['site_id'] == $item->id)
								<option value="{{ $item->id }}" selected>{{ $item->name }}</option>
							@else
								<option value="{{ $item->id }}">{{ $item->name }}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="class" class="col-sm-2 control-label">Setting Group</label>
				<div class="col-sm-10 ">
					<input type="text" class="form-control" name="class" id="class" value="{{ $vars['setting']['class'] or '' }}">
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10 ">
					<input type="text" class="form-control" name="name" id="name" value="{{ $vars['setting']['name'] or '' }}">
				</div>
			</div>
			<div class="form-group">
				<label for="value" class="col-sm-2 control-label">Value</label>
				<div class="col-sm-10 ">
					<textarea name="value" id="value" class="form-control">{{ $vars['setting']['value'] or '' }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label for="serialized">
							<input type="checkbox" name="serialized" id="serialized" value="1" {{ $vars['setting']['serialized'] == 1 ? 'checked' : '' }}>
						Serialized</label>
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