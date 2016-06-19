@extends( 'themes.BlackGray.admin.AdminPatternTemplate' )

@section('pageSubtitle')
- Student List
@stop

@section('adminPageContent')
	@if ( count( session( 'customMessage' ) ) > 0 )
	{{--*/ $msg = (array)session( 'customMessage' ) /*--}}
		<div class="alert alert-{{ $msg[ 'type' ] }}">
	  			<p><strong> <span class="glyphicon glyphicon-{{ $msg[ 'icon' ] }}"></span> {{ $msg[ 'content' ] }}</strong></p>
		</div>
	{!! Session::forget( 'customMessage' ) !!}
	@endif

	{!! Form::feature( $textControl, $alias, $showable, $search ) !!}
	<table class="table table-hover">
		<thead>
			<tr>
				@if( isset( $list[0]['original'] ) )
					<th>&nbsp;</th>
					@foreach ($list[0]['original'] as $key => $value)
						@if( $key == 'data_display' ||  $key == 'data_sort' || $key == 'data_default')
							<th style="text-transform:uppercase; font-weight: bold; width: 5%; ">{{$key}}</th>
						@else
							<th style="text-transform:uppercase; font-weight: bold">{{$key}}</th>
						@endif
					@endforeach
				@else
					<th>&nbsp;</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@if( isset( $list[0]['original'] ) )
				@foreach( $list as $index => $item )
				
				<tr>
					<td><input type="checkbox" class="itemCheck" name="selected_item" value="{{ $item->id }}"></td>
					@foreach( $item['original'] as $key => $value )

						@if( $key == 'data_display' )
							<td class="pointer" style="text-align: center"><span class="glyphicon glyphicon-eye-{{ ( $value == 1 ) ? 'open' : 'close lightgray' }}"></span></td>
						@endif

						@if( $key == 'data_default' )
							<td class="pointer"  style="text-align: center"><span class="glyphicon glyphicon-{{ ( $value == 1 ) ? 'ok' : 'remove lightgray' }}"></span></td>
						@endif

						@if( $key == 'data_sort' )
							{{--*/ $currentId = $item['original'][ 'id' ] /*--}}
							<td class="pointer"  style="text-align: center">
							@if( $start_index - 1 >= 0 )
								{{--*/ $lastId = $all[ $start_index - 1 ][ 'id' ] /*--}}
								<a href="{{ route( 'customers.swapsort', [ $currentId, $lastId ] ) }}"><span class="glyphicon glyphicon-arrow-up"></span></a>
							@endif

							@if( $start_index + 1 < $list->total() )
								{{--*/ $nextId = $all[ $start_index + 1 ][ 'id' ] /*--}}
								<a href="{{ route( 'customers.swapsort', [ $currentId, $nextId ] ) }}"><span class="glyphicon glyphicon-arrow-down"></span></a>
							@endif

							</td>
						@endif

						@if( $key != 'data_display' &&  $key != 'data_sort' && $key != 'data_default')
							<td>{{ $value }}</td>
						@endif
					@endforeach
				</tr>
				{{--*/ $start_index++ /*--}}
				@endforeach
			@else
				<td align="center" style="color: #b3b3b3; font-weight:bolder">{{ $list['no_record_message'] }}</td>
			@endif	
		</tbody>
	</table>
	@if( isset( $list[0]['original'] ) )
		<center>{!! $list->appends( [ 'search' => $search ] )->render() !!}</center>
	@endif
@stop