<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left
        }

        h3 {
            margin: 0
        }
    </style>
</head>

<body>
    <h3>Data Penduduk</h3>
    <table>
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>JK</th>
                <th>RT</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($items ?? []) as $i): ?>
                <tr>
                    <td><?= esc($i['nik']) ?></td>
                    <td><?= esc($i['nama_lengkap']) ?></td>
                    <td><?= esc($i['jenis_kelamin']) ?></td>
                    <td><?= esc($i['rt_id']) ?></td>
                    <td><?= esc($i['alamat']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>