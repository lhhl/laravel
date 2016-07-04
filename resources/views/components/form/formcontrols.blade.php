@foreach( $formRender as $key => $value )
<div class="form-group">

	@if( $key == '#control' )
		<p align="center"> 
	    	{!! Form::submit( $value[ 'submit' ], [ 'class' => 'btn btn-success' ] ) !!}
	    
	    	{!! Form::reset( $value[ 'reset' ], [ 'class' => 'btn btn-default' ] ) !!}
	    
	    	{!! Form::button( $value[ 'back' ], [ 'class' => 'btn btn-info', 'onclick' => 'location.href="' . action( $alias . 'Controller@index', [ 'page' => $page ]) . '"' ] ) !!}
	    </p>
	@else
		@if( $value[ 'type' ] != 'hidden' )
		{{ Form::label($key, $value[ 'title' ], ['class' => 'control-label']) }}
		@endif

	    @if( $value[ 'type' ] == 'textbox' )
	    	{{ Form::text($key, $value[ 'default_value' ], ['class' => 'form-control', 'placeholder' => $value[ 'placeholder' ]]) }}
	    @endif

	    @if( $value[ 'type' ] == 'hidden' )
	    	{{ Form::hidden($key, $value[ 'default_value' ]) }}
	    @endif

	    @if( $value[ 'type' ] == 'number' )
	    	{{ Form::number($key, $value[ 'default_value' ], ['class' => 'form-control', 'placeholder' => $value[ 'placeholder' ]]) }}
	    @endif

	    @if( $value[ 'type' ] == 'select' )
	    	{{ Form::select($key, array_merge([ '' => '--Select--' ], $value[ 'default_value' ]->toArray()), null, ['class' => 'form-control' ]) }}
	    @endif

	    @if( $value[ 'type' ] == 'file' )
	    	<p style="margin-left: 10px">
	    	{!! Form::button( $value[ 'default_value' ], [ 'class' => 'btn btn-success', 'btname' => 'fileButton' ] ) !!}
	    	{!! Form::button( 'Remove', [ 'class' => 'btn btn-danger', 'name' => 'removeImg' ] ) !!}
	    	</p>
	    	<div class="panel panel-success" style="margin-top: 10px;">
				<div class="panel-heading">Image Preview</div>
				<div class="panel-body imgPreview"><p align="center">Loading...</p></div>
            </div>

	    	{!! Form::hidden( $key ) !!}
	    @endif

	    @if( $value[ 'type' ] == 'radio' )
	    <p style="margin-left: 10px">
	    	@foreach( (array)$value[ 'default_value' ] as $k => $v )
	    		{{ Form::radio($key, $k) }} {{$v}} &nbsp;&nbsp;
	    	@endforeach
	    </p>
	    @endif

	    @if( $value[ 'type' ] == 'checkbox' )
	    <p style="margin-left: 10px">
	    		{{ Form::checkbox($key, 1) }} {{ $value[ 'default_value' ] }}
	    </p>
	    @endif
	@endif

</div>
@endforeach