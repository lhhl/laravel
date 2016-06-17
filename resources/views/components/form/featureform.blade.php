@if( in_array( 'add', $showable ) )
	<div style="margin:10px"> 
	{!! Form::open([ 'action' => $alias . 'Controller@create', 'method' => 'GET', 'style' => 'display: inline-block; float:left; margin-right: 10px' ]) !!}
		{!! Form::submit( $textControl[ 'add_button' ], [ 'class' => 'btn btn-success' ] ) !!}
	{!! Form::close() !!}
@endif

@if( in_array( 'edit', $showable ) )
	{!! Form::open([ 'action' => [$alias . 'Controller@edit', 'idRecord'], 'featureName' => 'formModify', 'name' => 'formEdit', 'method' => 'GET', 'style' => 'display: inline-block; float:left; margin-right: 10px' ]) !!}
		{!! Form::submit( $textControl[ 'edit_button' ], [ 'class' => 'btn btn-warning' ] ) !!}
	{!! Form::close() !!}
@endif

@if( in_array( 'delete', $showable ) )
	{!! Form::open([ 'action' => [ $alias . 'Controller@multidestroy'], 'featureName' => 'formModify', 'name' => 'formDel', 'method' => 'POST', 'style' => 'display: inline-block; float:left; margin-right: 10px' ]) !!}
		{!! Form::hidden( 'idRecord','1', [ 'id' => 'idRecord' ] ) !!}
		{!! Form::submit( $textControl[ 'del_button' ], [ 'class' => 'btn btn-danger' ] ) !!}
	{!! Form::close() !!}
@endif

@if( in_array( 'display', $showable ) )
	{!! Form::open([ 'action' => [ $alias . 'Controller@destroy', '1'], 'method' => 'DELETE', 'style' => 'display: inline-block; float:left; margin-right: 10px' ]) !!}
		{!! Form::submit( $textControl[ 'display_button' ], [ 'class' => 'btn btn-info' ] ) !!}
	{!! Form::close() !!}
	</div>
@endif