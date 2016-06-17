@extends( 'themes.BlackGray.admin.AdminPatternTemplate' )

@section('pageSubtitle')
- Student List
@stop

@section('adminPageContent')
	@if ( count( session( 'custom_error' ) ) > 0 )
		<div class="alert alert-danger">
			@foreach( session( 'custom_error' ) as $error )
	  			<p><strong> - {{$error}}</strong></p>
	  		@endforeach
		</div>
	{!! Session::forget( 'custom_error' ) !!}
	@endif

	{!! Form::feature( $textControl, $alias, $showable ) !!}	
	<table class="table table-hover">
		<thead>
			<tr>
				@if( isset( $list[0]['original'] ) )
					<th>&nbsp;</th>
					@foreach ($list[0]['original'] as $key => $value)
						<th style="text-transform:uppercase; font-weight: bold">{{$key}}</th>
					@endforeach
				@else
					<th>&nbsp;</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@if( isset( $list[0]['original'] ) )
				@foreach( $list as $item )
				<tr>
					<td><input type="checkbox" class="itemCheck" name="selected_item" value="{{ $item->id }}"></td>
					@foreach( $item['original'] as $key => $value )
						<td>{{ $value }}</td>
					@endforeach
				</tr>
				@endforeach
			@else
				<td align="center" style="color: #b3b3b3; font-weight:bolder">{{ $list['no_record_message'] }}</td>
			@endif	
		</tbody>
	</table>
	@if( isset( $list[0]['original'] ) )
		<center>{!! $list->render() !!}</center>
	@endif
@stop