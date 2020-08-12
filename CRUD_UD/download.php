<!DOCTYPE html>
<html>
<head>
	<title>Download File</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div id="container">
    	<div id="header">
    		<h1>Download File</h1>
        </div>
        <div id="menu">
        	<a href="book.php">Home</a>
            <a href="upload.php">Upload</a>
            <a href="download.php" class="active">Download</a>
			<a href="index.php">Logout</a>
        </div>
        <div id="content">
        	<h2>Download</h2>
            <p>Please download the file that has been uploaded on this website. To download you can click on the desired file title.</p>
 
            <p>
            <table class="table" width="100%" cellpadding="3" cellspacing="0">
            	<tr>
                	<th width="30">No.</th>
                    <th width="80">Tgl. Upload</th>
                    <th>Nama File</th>
                    <th width="70">Tipe</th>
                    <th width="70">Ukuran</th>
                </tr>
                <?php
				include('config.php');
				$koneksi = mysqli_connect("localhost","root","","db_pwl");
				$sql = ("SELECT * FROM file_upload ORDER BY id DESC");
				$download = mysqli_query($koneksi, $sql); 
				
				if(mysqli_num_rows($download) > 0){
					$no = 1;
					while($data = mysqli_fetch_assoc($download)){
						echo '
						<tr bgcolor="#fff">
							<td align="center">'.$no.'</td>
							<td align="center">'.$data['tanggal_upload'].'</td>
							<td><a href="'.$data['file'].'">'.$data['nama_file'].'</a></td>
							<td align="center">'.$data['tipe_file'].'</td>
							<td align="center">'.formatBytes($data['ukuran_file']).'</td>
						</tr>
						';
						$no++;
					}
				}else{
					echo '
					<tr bgcolor="#fff">
						<td align="center" colspan="4" align="center">Tidak ada data!</td>
					</tr>
					';
				}
				?>
            </table>
            </p>
        </div>
    </div>
</body>
</html>