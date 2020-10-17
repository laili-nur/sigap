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
                <div>
                    <span style="float:left;">Judul Buku</span>
                    <span style="float:right;">:</span>
                </div>
            </td>
            <td><span><?= $book_title; ?></span></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div>
                    <span style="float:left;">Jumlah Halaman</span>
                    <span style="float:right;">:</span>
                </div>
            </td>
            <td><span><?= $book_pages; ?></span></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div>
                    <span style="float:left;">Kertas Isi</span>
                    <span style="float:right;">:</span>
                </div>
            </td>
            <td><span><?= $paper_content; ?></span></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div>
                    <span style="float:left;">Kertas Cover</span>
                    <span style="float:right;">:</span>
                </div>
            </td>
            <td><span><?= $paper_cover; ?></span></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div>
                    <span style="float:left;">Jumlah Cetak</span>
                    <span style="float:right;">:</span>
                </div>
            </td>
            <td><span><?= $total . " EKS"; ?></span></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div>
                    <span style="float:left;">Cetakan Ke</span>
                    <span style="float:right;">:</span>
                </div>
            </td>
            <td><span><?= $book_edition; ?></span></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div>
                    <span style="float:left;">Revisi</span>
                    <span style="float:right;">:</span>
                </div>
            </td>
            <td><span><?php if ($category != 'revise') {
                            echo 'YA';
                        } else {
                            echo 'TIDAK';
                        }; ?></span></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div>
                    <span style="float:left;">Harga</span>
                    <span style="float:right;">:</span>
                </div>
            </td>
            <td><span><?= $harga; ?></span></td>
        </tr>
        <tr>
            <td style="width:150px">
                <div>
                    <span style="float:left;">Tipe Cetak</span>
                    <span style="float:right;">:</span>
                </div>
            </td>
            <td><span><?= $type; ?></span></td>
        </tr>
        <tr>
            <td style="width:150px">Catatan :</td>
        </tr>
        <tr>
            <td><span><?= $print_order_notes; ?></span></td>
        </tr>
    </table><br><br><br>
    <h2>Koordinasi Pemasaran</h2><br><br><br>
    <h2>Dimas</h2>

</body>

</html>
