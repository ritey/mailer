@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

	<div class="col-md-12">
		<a href="{{ route('sites.home', ['id' => $vars['site_id']]) }}">{{ $vars['site']->name }} options</a>
		<hr />
	</div>

	<div class="col-md-12">

		<form method="post" action="{{ $vars['action'] }}" class="form-horizontal" enctype="multipart/form-data">

			<legend>{{ $vars['legend'] }}</legend>

			{!! csrf_field() !!}

			<div class="form-group">
				<label for="tags" class="col-sm-2 control-label">Lists</label>
				<div class="col-sm-10 ">
					<input type="text" class="form-control" name="tags" id="tags" value="">
					@if(count($vars['tags']))
						<p class="help-block">Lists:
							@foreach($vars['tags'] as $tag)
								<a class="tag" href="#{{ $tag->name }}">{{ $tag->name }}</a>
							@endforeach
						</p>
					@endif
					<p class="help-block">Comma seperate lists if multiples are being added</p>
				</div>
			</div>

			<hr />

			<div class="form-group">
				<label for="emails" class="col-sm-2 control-label">Enter emails</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="emails" id="emails" value="">
					<p class="help-block">Comma seperate emails if multiples are being added</p>
				</div>
			</div>

			<div class="form-group">
				<label for="email_file" class="col-sm-2 control-label">or upload CSV</label>
				<div class="col-sm-10">
					<div class="checkbox">
						<label for="email_file">
							<input type="file" name="email_file" id="email_file">
						</label>
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

@section('footer')
	<script type="text/javascript">
	$('document').ready(function() {
		$('.tag').on('click',function(e) {
			e.preventDefault();
			$val = $('#tags').val();
			if ($val && $val != $(this).html()) {
				$('#tags').val($val + ',' + $(this).html());
			} else {
				$('#tags').val($(this).html());
			}
		});
	});
	</script>
@endsection