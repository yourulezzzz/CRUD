<?php
	ob_start();
	session_start();
	$user 		= $_POST['user'];
	$password 	= $_POST['password'];
	$database	= "login";
	$_SESSION['user'] = $user;
		$Open = mysqli_connect("localhost","root","","db_pwl");
		if (!$Open){
		die ("Koneksi ke Engine MySQL Gagal !");
		}
	$sql = "SELECT * FROM admin where user='$user'";
	$qry = mysqli_query($Open,$sql);
	$num = mysqli_num_rows($qry);
	$row = mysqli_fetch_array($qry);

	if ($num==0 OR $password!=$row['password']) {
?>
	<script language="JavaScript">
	alert('Username atau Password tidak sesuai !');
	document.location='index.php';

	</script>
<?php
	}
	else {
		$_SESSION['login']=1;
	header("Location: book.php");
	}
mysqli_close($Open); //Tutup koneksi engine MySQL
?>
