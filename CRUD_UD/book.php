<!DOCTYPE html>
<html>
<head>
	<title>Book Collection</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div id="container">
    <div id="header">
        <h1>Book Collection</h1>
    </div>
        <div id="menu">
        	<a href="book.php" class="active">Home</a>
            <a href="upload.php">Upload</a>
            <a href="download.php">Download</a>
            <a href="index.php">Logout</a>
        </div>
        <div id="content">
            <h2>Insert Book</h2>
            <p>Whenever you read a good book, somewhere in the world a door opens to allow in more light.</p>

            <?php 

			//CONNECTION DATABASE
			$koneksi = mysqli_connect("localhost","root","","db_pwl");

			//FUNCTION INSERT DATA 
			function tambah($koneksi){
				if(isset($_POST['btn_simpan'])){
					$id = time();
					$judul = $_POST['judul'];
					$pengarang = $_POST['pengarang'];
					$penerbit = $_POST['penerbit'];
					$tahun = $_POST['tahun'];

					if(!empty($judul) && !empty($pengarang) && !empty($penerbit) && !empty($tahun)){
						$sql= "INSERT INTO book( judul, pengarang, penerbit, tahun) VALUES ( '".$_POST['judul']."', '".$_POST['pengarang']."', '".$_POST['penerbit']."', '".$_POST['tahun']."');"; 
						$simpan = mysqli_query($koneksi, $sql) or die ("Proses Tambah data GAGAL! <br> "); 
						if($simpan && isset($_GET['aksi']) ){
							if($_GET['aksi'] == 'create'){
								header('Location: book.php');
							}
						}
					}else{
						$pesan = "<p style='color: red'>Tidak dapat menyimpan atau data belum lengkap!</p>";
					}
				}

			?>

            <p>
            <form action="" method="post" enctype="multipart/form-data">
            <table width="100%" align="center" border="0" bgcolor="#eee" cellpadding="2" cellspacing="0">
				<tr>
					<td></td>
					<td><input type="hidden" name="id"></td>
				</tr>
				<tr>
					<td> Judul Buku </td>
					<td><input type="text" name="judul"></td>
				</tr>
				<tr>
					<td> Pengarang Buku </td>
					<td><input type="text" name="pengarang"></td>
				</tr>
				<tr>
					<td> Penerbit Buku</td>
					<td><input type="text" name="penerbit"></td>
				</tr>
					<tr>
					<td> Tahun </td>
					<td><input type="text" name="tahun"></td>
				</tr>
				<tr>
				<td colspan="2">
				<center>
					<button type="submit" name="btn_simpan" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
					<button type="reset" class="btn btn-danger"><i class="fa fa-reply-all"></i> Clear </button>
				</center>   
				</td>
				</tr>
            </table>
			<p><?php echo isset($pesan) ? $pesan : "" ?></p>
            </form>
            </p>
			
	<?php 

	}
			
//FUNCTION VIEW DATA 
function tampil_data($koneksi){
	$seleksi = ("SELECT * FROM book order by id")or die(mysqli_error());
	$hasil_seleksi = mysqli_query ($koneksi,$seleksi);

    echo"<center>";
    echo"<legend><h3 style='margin-top:0px;'> Book List </h3></legend>";

    echo"<table class='tabel-data' class='table-hover' class='table-bordered' border='1' >";
    echo"<tr>
        <th>Kode</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Penerbit</th>
        <th>Tahun</th>
		<td colspan=2> Action </td>
        </tr>";
    while($data = mysqli_fetch_array($hasil_seleksi)){

        ?>
        <tr>
			
            <td><?php echo $data['id']; ?></td>
            <td><?php echo $data['judul']; ?></td>
            <td><?php echo $data['pengarang']; ?></td>
            <td><?php echo $data['penerbit']; ?></td>
            <td><?php echo $data['tahun']; ?></td>			

			<td>
				<a href="book.php?aksi=update&id=<?= $data['id']; ?>&judul=<?= $data['judul']; ?>&pengarang=<?= $data['pengarang']; ?>&penerbit=<?= $data['penerbit']; ?>&tahun=<?= $data['tahun']; ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit </a>
			</td>
			<td>
				<a href="book.php?aksi=delete&id=<?= $data['id']; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete </a>
			</td>  
        </tr>
		
<?php
}


}

//FUNCTION EDIT 
function ubah($koneksi){
    if(isset($_POST['btn_ubah'])){
        $id = $_POST['id'];
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $penerbit = $_POST['penerbit'];

        if(!empty($judul) && !empty($pengarang) && !empty($penerbit)){
            $sql_update = "UPDATE book SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit' WHERE id=$id";
            $update = mysqli_query($koneksi, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('Location: book.php');
                }
            }
        }else{
            $pesan = "Data Tidak Lengkap!";
        }
    }
    if(isset($_GET['id'])){
       
       ?>

        <a href="book.php" class="btn btn-info"><i class="fa fa-home"></i> Home</a> &nbsp;
            <a href="book.php?aksi=create" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data</a>
            <hr>
            <center>
            <form action="" method="POST">
            <h2>Ubah data</h2>
            <table>
            <tr>
            <td></td>
                <td><input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/></td>
                </tr>
                <tr>
                <td>Judul </td>
                <td><input type="text" name="judul" value="<?php echo $_GET['judul'] ?>"/></td>
                </tr>
                <tr>
                <td>Pengarang </td>
                <td><input type="text" name="pengarang" value="<?php echo $_GET['pengarang'] ?>"/></td>
                </tr>
                <tr>
                <td>Penerbit </td>
                <td><input type="text" name="penerbit" value="<?php echo $_GET['penerbit'] ?>"/></td>
                </tr>
				<tr>
                <td>Tahun </td>
                <td><input type="text" name="tahun" value="<?php echo $_GET['tahun'] ?>"/></td>
                </tr>
                <td>
                </td>
                <td>
                <button type="submit" name="btn_ubah" class="btn btn-success"><i class="fa fa-save"></i> Update </button>
                </td>
                </tr>
                </table>
                <p><?php echo isset($pesan) ? $pesan : "" ?></p>
               
            </form>
            </center>
        <?php
    }
   
}

// --- Tutup Fungsi Update
// FUNCTION DELETE DATA 
function hapus($koneksi){
    if(isset($_GET['id']) && isset($_GET['aksi'])){
        $id = $_GET['id'];
        $sql_hapus = "DELETE FROM book WHERE id=" . $id;
        $hapus = mysqli_query($koneksi, $sql_hapus);
       
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                header('Location: book.php');
            }
        }
    }
   
}

// --- Tutup Fungsi Hapus
// ===================================================================
// --- Program Utama
if (isset($_GET['aksi'])){
    switch($_GET['aksi']){
        case "create":
            echo '<a href="book.php" class="btn btn-info"> &laquo; Home</a>';
            tambah($koneksi);
            break;
        case "read":
            tampil_data($koneksi);
            break;
        case "update":
            ubah($koneksi);
            tampil_data($koneksi);
            break;
        case "delete":
            hapus($koneksi);
            break;
        default:
            echo "<h3>Aksi <i>".$_GET['aksi']."</i> tidak ada!</h3>";
            tambah($koneksi);
            tampil_data($koneksi);
    }
} else {
    tambah($koneksi);
    tampil_data($koneksi);
}
?>		
			
            </div>
    </div>
</body>
</html>

