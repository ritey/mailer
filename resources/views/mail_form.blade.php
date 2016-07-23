@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

	<div class="col-md-12">
		<a href="{{ route('sites.home', ['id' => $vars['site_id']]) }}">Site options</a>
		<hr />
	</div>

	<div class="col-md-12">

		<form method="post" action="{{ $vars['action'] }}" class="form-horizontal" enctype="multipart/form-data">

			<legend>{{ $vars['legend'] }}</legend>

			{!! csrf_field() !!}

			<div class="form-group">
				<label for="tag" class="col-sm-2 control-label">Send to tag:</label>
				<div class="col-sm-10 ">
					<input type="text" class="form-control" name="tag" id="tag" value="">
					<p class="help-block">Tags:
						@foreach($vars['tags'] as $tag)
							<a class="tag" href="#{{ $tag->name }}">{{ $tag->name }}</a>
						@endforeach
					</p>
					<p class="help-block">Comma seperate tags if multiples are being added</p>
				</div>
			</div>

			<hr />

			<div class="form-group">
				<label for="subject" class="col-sm-2 control-label">Subject</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="subject" autocomplete="false" id="subject" value="">
				</div>
			</div>

			<div class="form-group">
				<label for="message" class="col-sm-2 control-label">HTML Message</label>
				<div class="col-sm-10 ">
					<textarea name="message" rows="5" id="message" class="form-control"></textarea>
				</div>
			</div>

			<div class="form-group">
				<label for="plain_message" class="col-sm-2 control-label">Plain Text Message</label>
				<div class="col-sm-10 ">
					<textarea name="plain_message" rows="5" id="plain_message" class="form-control"></textarea>
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
			$val = $('#tag').val();
			if ($val && $val != $(this).html()) {
				$('#tag').val($val + ',' + $(this).html());
			} else {
				$('#tag').val($(this).html());
			}
		});
	});
	</script>
@endsection