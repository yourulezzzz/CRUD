<!DOCTYPE html>
<html>
<head>
	<title>Upload File</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div id="container">
    	<div id="header">
    		<h1>Upload File</h1>
        </div>

        <div id="menu">
        	<a href="book.php">Home</a>
            <a href="upload.php" class="active">Upload</a>
            <a href="download.php">Download</a>
			<a href="index.php">Logout</a>
        </div>

        <div id="content">
        	<h2>Upload</h2>
            <p>Upload your file by completing the form below. Files that can be uploaded are only files with extensions <b> .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip </b> and maximum file size (file size) only 1MB.</p>

            <?php
			include('config.php');
			if( isset ($_POST['upload'])){
				$allowed_ext	= array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip');
				$file_name		= $_FILES['file']['name'];
				$file_ext		= pathinfo($file_name, PATHINFO_EXTENSION);
				$file_size		= $_FILES['file']['size'];
				$file_tmp		= $_FILES['file']['tmp_name'];

				$nama			= $_POST['nama'];
				$tgl			= date("Y-m-d");

				$koneksi = mysqli_connect("localhost","root","","db_pwl");
				
				if(in_array($file_ext, $allowed_ext) === true){
					if($file_size < 1044070){
						$lokasi = 'C:/xampp/htdocs/PWL/WebProject/upload/'.$nama.'.'.$file_ext;
						move_uploaded_file($file_tmp, $lokasi);
						$sql = ("INSERT INTO file_upload VALUES(NULL, '$tgl', '$nama', '$file_ext', '$file_size', '$lokasi')");
						$simpan = mysqli_query($koneksi, $sql) or	 die ("Proses Tambah data GAGAL! <br> "); 
						if($sql){
							echo '<div class="ok">SUCCESS: File berhasil di Upload!</div>';
						}else{
							echo '<div class="error">ERROR: Gagal upload file!</div>';
						}
					}else{
						echo '<div class="error">ERROR: Besar ukuran file (file size) maksimal 1 Mb!</div>';
					}
				}else{
					echo '<div class="error">ERROR: Ekstensi file tidak di izinkan!</div>';
				}
			}
			?>

            <p>
            <form action="" method="post" enctype="multipart/form-data">
            <table width="100%" align="center" border="0" bgcolor="#eee" cellpadding="2" cellspacing="0">
            	<tr>
                	<td width="40%" align="right"><b>Nama File</b></td><td><b>:</b></td><td><input type="text" name="nama" size="40" required /></td>
                </tr>
                <tr>
                	<td width="40%" align="right"><b>Pilih File</b></td><td><b>:</b></td><td><input type="file" name="file" required /></td>
                </tr>
                <tr>
                	<td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="upload" value="Upload" /></td>
                </tr>
            </table>
            </form>
            </p>
        </div>
    </div>
</body>
</html>