@extends('admin.layouts.base')

@section('content')
	<div class="page-wrapper-helper">
		<div class="row">
			<div class="col-lg-12">
				<form action="{{route('bots.create')}}" method="post">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" placeholder="Bot name" name="name">
					</div>
					<div class="form-group">
						<label for="backend_url">Backend Url</label>
						<input type="text" class="form-control" id="backend_url" placeholder="Backend url" name="backend_url">
					</div>
					<div class="form-group">
						<label for="access_token">Access Token</label>
						<input type="text" class="form-control" id="access_token" placeholder="Bot access token" name="access_token">
					</div name="name">
					<div class="form-group">
						<label for="platform">Platform</label>
						<input type="text" class="form-control" id="platform" placeholder="Platform" name="platform">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
			<!-- /.col-lg-12 -->
		</div>
	</div>
@stop