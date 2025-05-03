<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .container {
            border: 1px solid #000;
            padding: 20px;
            width: 100%;
        }
        h2 {
            text-align: center;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Slip Gaji Karyawan</h2>

        <div class="info">
            <p><strong>Nama:</strong> {{ $gaji->user->nama }}</p>
            <p><strong>Posisi:</strong> {{ $gaji->user->posisi }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($gaji->tanggal)->format('d F Y') }}</p>
        </div>

        <table>
            <tr>
                <th>Komponen</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <td>Bonus</td>
                <td>Rp {{ number_format($gaji->bonus, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Potongan</td>
                <td>Rp {{ number_format($gaji->deduction, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td>Total Gaji</td>
                <td>
                    Rp {{ number_format($gaji->user->gaji + $gaji->bonus - $gaji->deduction, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
