<!DOCTYPE html>
<html>
<head>
	<title>Template</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

	@if( $pageArg == "list" )
		{!! Form::open([ 'action' => 'StudentsController@AddStd' ]) !!}
			<input type="button" name="add" value="Thêm mới" onclick="window.location.href='students/add'">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>&nbsp;</th>
							@foreach ($header as $item)
								<th>{{ $item }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach( $list as $item )
						<tr>
							<td><input type="checkbox" name="selected_item" value="{{ $item->id }}"></td>
							<td>{{ $item->id }}</td>
							<td>{{ $item->name }} </td>
							<td>{{ $item->age }} </td>
							<td>{{ $item->rate }}</td>
							<td>{{ $item->created_at }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div style="float: right">{!! $list->render() !!}</div>
		{!! Form::close() !!}

	@endif

	@if( $pageArg == "add" )
		{!! Form::open([ 'action' => 'StudentsController@AddStd' ]) !!}
			{!! Form::label( 'name', 'Student\'s Name:' ) !!}
			{!! Form::text( 'name' ) !!} <br>

			{!! Form::label( 'age', 'Student\'s Age:' ) !!}
			{!! Form::text( 'age' ) !!} <br>

			{!! Form::label( 'rate', 'Student\'s Rate:' ) !!}
			{!! Form::text( 'rate' ) !!} <br>

			{!! Form::label('created_at','Created Date:') !!}
			{!! Form::input('date', 'created_at', date("Y-m-d")) !!} <br />

			{!! Form::submit( 'Add new' ) !!}
			{!! Form::reset( 'Cancel' ) !!}
		{!! Form::close() !!}
	@endif

</body>
</html>