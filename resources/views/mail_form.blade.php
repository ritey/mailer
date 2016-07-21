@extends('master')

@section('metas')
<title>{{ $vars['legend'] }}</title>
@endsection

@section('content')

	<div class="col-md-12">

		<form method="post" action="{{ $vars['action'] }}" class="form-horizontal" enctype="multipart/form-data">

			<legend>{{ $vars['legend'] }}</legend>

			{!! csrf_field() !!}

			<div class="form-group">
				<label for="tag" class="col-sm-2 control-label">Send to tag:</label>
				<div class="col-sm-10 ">
					<input type="text" class="form-control" name="tag" id="tag" value="">
					<p class="help-block">Comma seperate tags if multiples are being added</p>
				</div>
			</div>

			<hr />

			<div class="form-group">
				<label for="subject" class="col-sm-2 control-label">Subject</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="subject" id="subject" value="">
				</div>
			</div>

			<div class="form-group">
				<label for="message" class="col-sm-2 control-label">Message</label>
				<div class="col-sm-10 ">
					<textarea name="message" id="message" class="form-control"></textarea>
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