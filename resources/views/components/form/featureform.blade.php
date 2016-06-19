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
		{!! Form::hidden( 'idRecord','1', [ 'class' => 'idRecord' ] ) !!}
		{!! Form::submit( $textControl[ 'del_button' ], [ 'class' => 'btn btn-danger' ] ) !!}
	{!! Form::close() !!}
@endif

@if( in_array( 'display', $showable ) )
	{!! Form::open([ 'action' => [ $alias . 'Controller@changedisplay'],'featureName' => 'formModify','name' => 'formDisplay', 'method' => 'POST', 'style' => 'display: inline-block; float:left; margin-right: 10px' ]) !!}
	{!! Form::hidden( 'idRecord','1', [ 'class' => 'idRecord' ] ) !!}
		{!! Form::submit( $textControl[ 'display_button' ], [ 'class' => 'btn btn-info' ] ) !!}
	{!! Form::close() !!}
	</div>
@endif

@if( in_array( 'default', $showable ) )
	{!! Form::open([ 'action' => [$alias . 'Controller@setdefault', 'idRecord'], 'featureName' => 'formModify', 'name' => 'formDefault', 'method' => 'GET', 'style' => 'display: inline-block; float:left; margin-right: 10px' ]) !!}
		{!! Form::submit( $textControl[ 'default_button' ], [ 'class' => 'btn btn-info' ] ) !!}
	{!! Form::close() !!}
@endif


{!! Form::open([ 'action' => [$alias . 'Controller@index', 'search'], 'method' => 'GET', 'style' => 'display: inline-block;  margin-right: 10px; margin-left: 20px; width: 30%' ]) !!}
	{{ Form::text( 'search', $search, ['class' => 'form-control', 'placeholder' => '...', 'style' => 'width: 80%; display: inline-block;']) }}
	{!! Form::submit( $textControl[ 'search_button' ], [ 'class' => 'btn btn-info' ] ) !!}
{!! Form::close() !!}
