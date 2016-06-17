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

	    @if( $value[ 'type' ] == 'radio' )
	    <p style="margin-left: 10px">
	    	@foreach( (array)$value[ 'default_value' ] as $k => $v )
	    		{{ Form::radio($key, $k, false) }} {{$v}} &nbsp;&nbsp;
	    	@endforeach
	    </p>
	    @endif
	@endif

</div>
@endforeach