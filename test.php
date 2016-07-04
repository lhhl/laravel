<?php //1 + 1*2 + 1*2*3
	
	function F( $n )
	{
		if( $n == 1  ) return 1;
		return $n * F( $n - 1 );
	}
	function Y( $n ){
		if( $n == 1  ) return 1;
		return $n * F( $n - 1 ) + Y( $n - 1 );
	}

	function testCurl()
	{
		$url = 'http://vnexpress.net/rss/cuoi.rss';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
	}
	header("Content-type: text/xml");
	echo testCurl();

?>