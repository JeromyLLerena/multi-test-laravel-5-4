@extends('admin.layouts.base')

@section('content')
	<div class="page-wrapper-helper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Bots list</h1>
				<table class="table table-hover">
					<tr>
						<th>Name</th>
						<th>Platform</th> 
						<th>Created</th>
						<th>Actions</th>
					</tr>
					<div class="subtitle">
						<a class="btn btn-info" href="{{route('bots.create')}}" role="button">Create</a>
					</div>
					@foreach($bots as $bot)
						<tr>
							<td>{{$bot->name}}</td>
							<td>{{$bot->platform}}</td> 
							<td>{{$bot->created_at}}</td>
							<td> <a href="{{route('bots.edit', $bot->id)}}"><span class="fa fa-pencil"></span></a> | <a href="#"><span class="fa fa-close"></span></a> </td>
						</tr>
					@endforeach
				</table>
			</div>
			<!-- /.col-lg-12 -->
		</div>
	</div>
@stop