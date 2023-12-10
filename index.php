<?php
require 'function.php';
$mahasiswa = query("SELECT * FROM mahasiswa");


    //tombol cari ditekan
    if(isset($_POST["cari"])){
        $mahasiswa = cari($_POST["keyword"]);
    }


?>
<!DOCTYPE html>
<html>

<head>
    <title>halaman admin</title>
</head>

<body>


    <h1>daftar mahasiswa</h1>

    <a href="tambah.php">tambah data mahasiswa</a>
    <br><br>

    <form action="" method="post">

        <input type="text" name="keyword" size="30" autofocus placeholder="masukan keyword pencarian"
            autocomplete="off">
        <button type="submit" name="cari">cari!</button>

    </form>
    <br>



    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>id</th>
            <th>aksi</th>
            <th>gambar</th>
            <th>nrp</th>
            <th>nama</th>
            <th>email</th>
            <th>jurusan</th>
        </tr>
        <?php foreach ($mahasiswa as $i => $row): ?>

            <tr>
                <td>
                    <?= $i + 1; ?>
                </td>

                <td>
                    <a href="ubah.php?id=<?= $row["id"]; ?>">ubah</a>
                    <a href="hapus.php?id=<?= $row["id"]; ?>" onclick=" return confirm('yakin?'); ">hapus</a>
                </td>
                <td><img src="img/<?= $row["gambar"]; ?>" width="50"></td>
                <td>
                    <?= $row["nrp"]; ?>
                </td>
                <td>
                    <?= $row["Nama"]; ?>
                </td>
                <td>
                    <?= $row["email"]; ?>
                </td>
                <td>
                    <?= $row["jurusan"]; ?>
                </td>

            </tr>
        <?php endforeach; ?>

    </table>
</body>

</html>