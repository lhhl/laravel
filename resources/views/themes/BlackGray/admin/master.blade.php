<!DOCTYPE html>
<html>
<head>
	<title>@yield('pageTitle')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	{!! Html::script('http://code.jquery.com/jquery-latest.min.js') !!}
	<script type="text/javascript">
		$().ready(function(){
			var arr = [];
			$( '[ featureName = "formModify" ]' ) . submit(function(){
				if( arr.length == 0 ){
					return false;
				}
			});


			$( '.itemCheck' ) . change( function(){
				arr = [];
				$( '.itemCheck:checked' ).each(function(){
					arr.push($(this).val());
				});

				$( '#idRecord' ) . val( arr );
				temp = $('[name = "formEdit"]') . attr( "action" ) . split('/');
				temp[ temp.length - 2 ] = arr[ arr.length - 1 ];

				$('[name = "formEdit"]') . attr( "action", temp . join('/') );
				console.log( temp . join() );
			});
		});
	</script>
</head>
<body>
@yield('pageContent')
</body>
</html>