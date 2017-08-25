		<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "yourpassword", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Change Password
<hr>

<?PHP
	if(isset($_POST['change']))
	{
		$oldpw = trim($_POST['oldpassword']);
		$newpw = trim($_POST['newpassword']);
		$query = "SELECT PASSWORD FROM AA_LOGIN WHERE password = '$oldpw'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row)
		{
			$query = "UPDATE AA_LOGIN SET password ='$newpw' WHERE password ='$oldpw'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			echo '<script>window.location = "MemberPage.php";</script>';
		}
		else
		{
		 echo "change fail.";
		}
	};
	oci_close($conn);
?>

<form action='changepw.php' method='post'>
	Set new password<br><br>
	Old Password <br>
	<input name='oldpassword' type='password'><br><br>
	New Password <br>
	<input name='newpassword' type='password'><br><br>
	<input name='change' type='submit' value='Change Password'>
</form>
