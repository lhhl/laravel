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

	function ftpTransfer()
	{
		$ftpServer = '192.168.0.229';
		$ftpUsername = 'root';
		$ftpPassword = '123456';
		$ftpConn = ftp_ssl_connect($ftpServer, 21) or die("Could not connect ssl ftp");
		//$ftpConn = ftp_connect($ftpServer, 21) or die("Could not connect");
		$login = ftp_login($ftpConn, $ftpUsername, $ftpPassword);
		ftp_pasv($ftpConn, true);
		echo "Connect successfully!";
		$file = "ftpTest.txt";
		if (ftp_put($ftpConn, "ftpTest.txt", $file, FTP_BINARY)) {
			echo "Uploaded";
		} else {
			echo "Error";
		}
		ftp_close($ftpConn);
		echo "Closed";
	}

	function sftpTransfer()
	{
		$ftpServer = '192.168.0.229';
		$ftpUsername = 'root';
		$ftpPassword = '123456';

		$connection = ssh2_connect($ftpServer);
		ssh2_auth_password($connection, $ftpUsername, $ftpPassword);
		$sftp = ssh2_sftp($connection);

		$stream = fopen("ssh2.sftp://$sftp/testsFTP.txt", "w+");
		$data = file_get_contents("ftpTest.txt");

		fwrite($stream, $data);
		fclose($stream);
	}

	sftpTransfer();
?>