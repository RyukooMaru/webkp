<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>
    <h3>Daftar Retur Penjualan</h3>
    @if ($headers->isEmpty())
        <p><em>Tidak ada data.</em></p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>No#</th>
                    <th>Tgl Kembali</th>
                    <th>Bruto</th>
                    <th>Disc</th>
                    <th>Pajak</th>
                    <th>Netto</th>
                    <th>Pengguna</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($headers as $h)
                    <tr>
                        <td>{{ $h->Trx_SupCode }}</td>
                        <td>{{ $h->trx_number }}</td>
                        <td>{{ $h->Trx_Date }}</td>
                        <td style="text-align:right">{{ number_format($h->Trx_GrossPrice, 2) }}</td>
                        <td style="text-align:right">{{ number_format($h->Trx_Discount, 2) }}</td>
                        <td style="text-align:right">{{ number_format($h->Trx_Taxes, 2) }}</td>
                        <td style="text-align:right">{{ number_format($h->Trx_NettPrice, 2) }}</td>
                        <td>{{ $h->Trx_UserID }}</td>
                        <td>{{ $h->Trx_LastUpdate }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
