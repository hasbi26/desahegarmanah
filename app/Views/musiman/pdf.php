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
    <h3>Data Penduduk Musiman</h3>
    <table>
        <thead>
            <tr>
                <th>Periode</th>
                <th>Penduduk ID</th>
                <th>RT</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($items ?? []) as $i): ?>
                <tr>
                    <td><?= esc($i['periode']) ?></td>
                    <td><?= esc($i['penduduk_id']) ?></td>
                    <td><?= esc($i['rt_id']) ?></td>
                    <td><?= esc($i['keterangan']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>