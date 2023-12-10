<?php
//koneksi database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function tambah($data)
{
    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;

    }else{
        $gambar = upload();
    }

    $gambar = htmlspecialchars($data["jurusan"]);
    
    //upload gambar
    $gambar = upload();
    if( !$gambar){
        return false;
    }


    // Insert data into the database
    $sql = "INSERT INTO mahasiswa (nama, nrp, email, jurusan, gambar) VALUES ('$nama', '$nrp', '$email', '$jurusan', '$gambar')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}


function upload(){

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah ada gambar yg di upload
    if($error === 4){
        echo "<script>
                    alert('pilih gambar terlebih dahulu');
                    </script>";
                    return false;       
    }

    //cek apakah yang di upload adalah gambar
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>
                alert('yang anda upload bukan gambar');
                </script>";
                return false;
    }

    //cek jika ukuran terlalu besar
    if ($ukuranFile > 1000000){
        echo "<script>
        alert('ukuran gambar terlalu besar');
        </script>";
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= ',';
    $namaFileBaru .= $ekstensiGambar;
 


    //lolos pengecekan,gambarsiap diupload
    move_uploaded_file($tmpName , 'img/' . $namaFileBaru);

    return $namaFileBaru;


}


function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}


function ubah($data)
{
    global $conn;

    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);




    $query = "UPDATE mahasiswa SET
    nrp = '$nrp',
    nama = '$nama',
    email = '$email',
    jurusan = '$jurusan'
  WHERE id = $id
";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function cari($keyword)
{
    $query = "SELECT * FROM mahasiswa
                    WHERE 
                nama LIKE '%$keyword%' OR
                nrp LIKe  '%$keyword%' OR
                email LIKe  '%$keyword%' OR
                jurusan LIKe  '%$keyword%'
                
            ";
        return query($query);
}




?>