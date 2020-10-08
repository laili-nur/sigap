<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <style>
    h1 {
        font-family: 'Calibri', sans-serif;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        color: black;
    }

    table {
        margin-left: 100px;
        margin-right: 100px;
    }

    tr {
        font-family: 'Calibri', sans-serif;
        font-weight: lighter;
        font-size: 18px;
        color: black;
    }

    h2 {
        font-family: 'Calibri', sans-serif;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        color: black;
        border-spacing: 50px;
    }

    </style>

</head>

<body>
    <h1>PERMINTAAN <?= $category; ?></h1>
    <table>
        <tr>
            <td style="width:150px">
                <div style="display: flex;justify-content: space-between;">
                    <span>Judul Buku</span>
                    <span style="margin-left: auto;">:</span>
                </div>
            </td>
            <td><?= $book_title; ?></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div style="display: flex;justify-content: space-between;">
                    <span>Jumlah Halaman</span>
                    <span style="margin-left: auto;">:</span>
                </div>
            </td>
            <td><?= $book_pages; ?></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div style="display: flex;justify-content: space-between;">
                    <span>Kertas Isi</span>
                    <span>:</span>
                </div>
            </td>
            <td><?= $paper_content; ?></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div style="display: flex;justify-content: space-between;">
                    <span>Kertas Cover</span>
                    <span>:</span>
                </div>
            </td>
            <td><?= $paper_cover; ?></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div style="display: flex;justify-content: space-between;">
                    <span>Jumlah Cetak</span>
                    <span>:</span>
                </div>
            </td>
            <td><?= $total . " EKS"; ?></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div style="display: flex;justify-content: space-between;">
                    <span>Cetakan Ke</span>
                    <span>:</span>
                </div>
            </td>
            <td><?= $book_edition; ?></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div style="display: flex;justify-content: space-between;">
                    <span>Revisi</span>
                    <span>:</span>
                </div>
            </td>
            <td><?php if ($category != 'revise') {
                    echo 'YA';
                } else {
                    echo 'TIDAK';
                }; ?></td>
        </tr>
        <!-- <tr>
            <td>Tipe Cetak</td>
            <td>:</td>
        </tr>
        <tr>
            <td>Tahun Terbit</td>
            <td>:</td>
        </tr> -->
        <tr>
            <td style="width:150px">
                <div style="display: flex;justify-content: space-between;">
                    <span>Harga</span>
                    <span>:</span>
                </div>
            </td>
            <td><?= $harga; ?></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div style="display: flex;justify-content: space-between;">
                    <span>Tipe Cetak</span>
                    <span>:</span>
                </div>
            </td>
            <td><?= $type; ?></td>
        </tr>
        <tr>
            <td>Catatan :<br><?= $print_order_notes; ?></td>
        </tr>
    </table><br><br><br>
    <h2>Koordinasi Pemasaran</h2><br><br><br>
    <h2>Dimas</h2>

</body>

</html>
