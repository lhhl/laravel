<!DOCTYPE html>
<html>
<head>
	<title>@yield('pageTitle')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	{!! Html::script('js/jquery.min.js') !!}
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	{!! Html::style('css/jquery.fileupload.css') !!}
	{!! Html::style('css/jquery.fileupload-ui.css') !!}
	{!! Html::script('js/vendor/jquery.ui.widget.js') !!}
	{!! Html::script('js/jquery.iframe-transport.js') !!}
	{!! Html::script('js/jquery.fileupload.js') !!}
	<script type="text/javascript">
		$().ready(function(){
            getStoreImage();
			var arr = [];
			$( '[ featureName = "formModify" ]' ) . submit(function(){
				if( arr.length == 0 ){
					return false;
				}
			});

			$( '.itemCheckAll' ) . change( function(){
				if( $( this ).is( ":checked" ) ){
					$( '.itemCheck' ) . prop( "checked", true ) . trigger( 'change' );
				}else{
					$( '.itemCheck' ) . prop( "checked", false ) . trigger( 'change' );
				}
			} );

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

            $('[name="image"]') . change(function (event) {
                 $('#output') . css({
                    'width'  : '120px',
                    'height' : '120px'
                 });
                $('#output') . attr('src', URL.createObjectURL(event.target.files[0]));
            });

			function generateLink( currLink ){
				var temp = currLink . split('/');
				temp[ temp.length - 2 ] = arr[ arr.length - 1 ];
				return temp . join('/');
			}

			$('[btname="fileButton"]') . click(function() {
				$("#customModal").modal({backdrop: "static"});
                //getStoreImage();
			});

            $('.panel') . delegate('[name="seletedImg"]', 'change', function () {
                imgNameArr = [];
                $( '[name="seletedImg"]:checked' ).each(function () {
                    imgNameArr.push($(this).val());
                });
                $('[name="image_name"]') . val(imgNameArr);
            });

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $('[name="removeImg"]') . click(function () {
                $.ajax({
                    method: "POST",
                    url: "{{ route('customers.clearimage') }}",
                    data: {
                        imageName : $('[name="image_name"]') . val(),
                        _token : csrfToken,
                    },
                    success: function (data) {
                        console . log(data);
                        getStoreImage();
                    },
                    error: function(data, status, error){
                        console . log(data);
                        console . log(status);
                        console . log(error);
                    },
                    statusCode: {
                        200: function() {
                          alert( "yeah" );
                        }
                      }
                });
            });

            function getStoreImage() {
                var imagePreview = '';
                $.ajax({
                    method: 'GET',
                    url: "{{ route('customers.getstoreimage') }}",
                    success: function (data) {
                        if(data.length > 0) {
                            for(var i = 0; i < data . length; i++) {
                                var str = '<div class="well well-success">';
                                str += '{{ Html::image(asset('images/{fileName}') ) }}';
                                str += '<p align="center">{{ Form::checkbox( 'seletedImg', '{fileName}' ) }}</p>';
                                str += '</div>';
                                str = str . replace(/{fileName}/g, data[i]);
                                imagePreview += str;
                            }
                            $('.imgPreview') . html('<p align="center">' + imagePreview + '</p>');
                        } else {
                            $('.imgPreview') . html('<p align="center" style="color: #bababa; font-style: italic">No image to display</p>');
                        }
                    }
                });
            }

			///////////////////////////////////

			$(function () {
			    $('#fileupload').fileupload({
			        add: function (e, data) {
                        
			        	$('[role="progressbar"]') . css( 'width', '0%' );
			        	$('[name="messagePanel"]') . css('display', 'none');

			        	$('[name="btnUpload"]') . removeAttr('disabled');
                        $( '[name="btnUpload"]' ) . unbind('click');
			            data.context = $( '[name="btnUpload"]' )
			                .click(function () {
			                $(this) . attr('disabled', 'disabled');
							data.submit();
			                    $('.progress') . css( 'opacity', "1" );
			                });
			            
			        },
			        progressall: function (e, data) {
				        var progress = parseInt(data.loaded / data.total * 100, 10);
				        $('[role="progressbar"]') . css( 'width', progress + '%' );
				        $('.progress-text') . text( progress + '% Uploaded' );
				    },
				    done: function (e, data) {
				    	$('[name="messagePanel"]') . attr('class', 'alert alert-success');
				    	$('[name="messagePanel"]') . removeAttr('style');
				    	$('.errorUploader') . text('Upload finished.');
			            $('.progress-text') . text('File has uploaded');
			            $('.progress') . animate({
			            	"opacity" : "0"
			            }, 1000);
			            getStoreImage();
			            $( '[name="btnUpload"]' ) . unbind('click');
			        },
			        error: function (e, data, error) {
			        	$('[name="messagePanel"]') . attr('class', 'alert alert-danger');
			        	$('[name="messagePanel"]') . removeAttr('style');
			        	$('.errorUploader') . text(error);
			        	$('[role="progressbar"]') . css( 'width', '0%' );
			        	$('.progress') . animate({
			            	"opacity" : "0"
			            }, 1000);
			           $( '[name="btnUpload"]' ) . unbind('click');
			        }

			    });
			});

			
		});

		

	</script>
	<style>
		.red { color: red; }
		.green { color: green; }
		.lightgray { color: lightgray; }
		.pointer .glyphicon { font-size: 18px; }
		.pointer :hover { cursor: pointer; }
        .imgPreview div{ display: inline-block; margin-right: 10px; padding: 5px; background-color: #dff0d8; padding-left: 10px; padding-right: 10px; }
        .imgPreview div:hover{ display: inline-block; margin-right: 10px; padding: 5px; background-color: #c4ecb4; padding-left: 10px; padding-right: 10px; }
        .imgPreview div img{ width: 80px; height: 80px; }
	</style>
</head>
<body>
@yield('pageContent')
</body>
</html>