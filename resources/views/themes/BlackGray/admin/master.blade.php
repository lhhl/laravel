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

				$( '.idRecord' ) . val( arr );

				$newLink = generateLink( $('[name = "formEdit"]') . attr( "action" ) );
				$('[name = "formEdit"]') . attr( 'action', $newLink );

				$newLink = generateLink( $('[name = "formDefault"]') . attr( "action" ) );
				$('[name = "formDefault"]') . attr( 'action', $newLink );
			});

			function generateLink( currLink ){
				var temp = currLink . split('/');
				temp[ temp.length - 2 ] = arr[ arr.length - 1 ];
				return temp . join('/');
			}
		});
	</script>
	<style>
		.red { color: red; }
		.green { color: green; }
		.lightgray { color: lightgray; }
		.glyphicon { font-size: 18px }
		.pointer :hover { cursor: pointer; }
	</style>
</head>
<body>
@yield('pageContent')
</body>
</html>