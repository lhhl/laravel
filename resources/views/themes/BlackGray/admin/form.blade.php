@extends( 'themes.BlackGray.admin.AdminPatternTemplate' )

@section('pageSubtitle')
- Add/edit Student
@stop

@section('adminPageContent')

	@if( $errors->any() )
		
		<div class="alert alert-danger">
		@foreach( $errors->all() as $error )
  			<p><strong> - {{$error}}</strong></p>
  		@endforeach
		</div>

	@endif

	@if( $status == "create" )
		{!! Form::open( [ 'action' => $alias . 'Controller@store', 'method' => 'POST', 'role' => 'form' ] ) !!}
	@else
		{!! Form::model( $record, [ 'action' => [ $alias . 'Controller@update', $record->id ], 'method' => 'PUT', 'role' => 'form' ] ) !!}
	@endif
		{!! Form::generate( $formRender, $alias, $page ) !!}	
		{!! Form::close() !!}
		{!! Form::uploader() !!}
@stop