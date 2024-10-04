<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan CPMI</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
            text-transform: uppercase;
            margin: 3px;
            padding: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th:first-child,
        td:first-child {
            text-align: left;
        }

        .header-table {
            border: none;
        }

        .header-table td {
            border: none;
            padding: 5px;
        }

        h1,
        p {
            margin: 0;
            padding: 0;
        }

        img {
            max-width: 100px;
        }
    </style>
</head>

<body>
    <table class="header-table" width="100%">
        <tr>
            <td width="33%" style="text-align: left;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" width="100">
            </td>
            <td width="33%" style="text-align: right;">
                <div>
                    <p><strong>Date:</strong> {{ date('d-m-Y H:i:s') }}</p>
                </div>
            </td>
        </tr>
    </table>

    <h1 align="center">Laporan PT P3MI</h1>
    <p align="center"><strong>Periode:</strong>
        {{ $start ? \Carbon\Carbon::parse($start)->format('d-m-Y') : 'Semua tanggal' }}
        s/d
        {{ $end ? \Carbon\Carbon::parse($end)->format('d-m-Y') : 'Sekarang' }}
    </p>

    <!-- Tabel Status -->
    <h2 align="center">Status</h2>
    <table>
        <thead>
            <tr>
                <th>Kantor</th>
                @foreach($statuses as $status)
                <th>{{ $status->nama }}</th>
                @endforeach
                <th>Total Status</th> <!-- Kolom Total untuk status -->
            </tr>
        </thead>
        <tbody>
            @foreach($jumlahData as $kantorNama => $dataStatus)
            <tr>
                <td>{{ $kantorNama }}</td>
                @php
                $totalStatus = 0;
                @endphp
                @foreach($statuses as $status)
                <td>{{ $dataStatus[$status->nama] ?? 0 }}</td>
                @php
                $totalStatus += $dataStatus[$status->nama] ?? 0;
                @endphp
                @endforeach
                <td><strong>{{ $totalStatus }}</strong></td> <!-- Total status untuk setiap kantor -->
            </tr>
            @endforeach
            <tr>
                <td><strong>Total</strong></td>
                @foreach($statuses as $status)
                <td><strong>{{ $totalPerStatus[$status->id] ?? 0 }}</strong></td>
                @endforeach
                <td><strong>{{ $grandTotal }}</strong></td> <!-- Grand total status -->
            </tr>
        </tbody>
    </table>

    <!-- Tabel Pra Medical, Siap Kerja, ID BP2MI, Dapat Job, Penerbangan -->
    <h2 align="center">Pra Medical, Siap Kerja, ID BP2MI, Dapat Job, Penerbangan</h2>
    <table>
        <thead>
            <tr>
                <th>Kantor</th>
                <th>Pra Medical</th>
                <th>Siap Kerja</th>
                <th>ID BP2MI</th>
                <th>Dapat Job</th>
                <th>Penerbangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kantors as $kantor)
            <tr>
                <td>{{ $kantor->nama }}</td>
                <td>{{ $jumlahPraMedical[$kantor->nama] ?? 0 }}</td> <!-- Pra Medical dari array -->
                <td>{{ $jumlahSiapKerja[$kantor->nama] ?? 0 }}</td> <!-- Siap Kerja dari array -->
                <td>{{ $jumlahBp2mi[$kantor->nama] ?? 0 }}</td> <!-- ID BP2MI dari array -->
                <td>{{ $jumlahDapatJob[$kantor->nama] ?? 0 }}</td> <!-- Dapat Job dari array -->
                <td>{{ $jumlahPenerbangan[$kantor->nama] ?? 0 }}</td> <!-- Penerbangan dari array -->
            </tr>
            @endforeach
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>{{ array_sum($jumlahPraMedical) }}</strong></td>
                <td><strong>{{ array_sum($jumlahSiapKerja) }}</strong></td>
                <td><strong>{{ array_sum($jumlahBp2mi) }}</strong></td>
                <td><strong>{{ array_sum($jumlahDapatJob) }}</strong></td>
                <td><strong>{{ array_sum($jumlahPenerbangan) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>

</html>