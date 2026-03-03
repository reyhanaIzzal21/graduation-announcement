<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Lulus</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            padding: 40px 60px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header .logo {
            width: 80px;
            height: 80px;
            margin-right: 15px;
            float: left;
        }

        .header .school-name {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .school-detail {
            font-size: 10pt;
        }

        .title {
            text-align: center;
            margin: 30px 0 20px;
        }

        .title h2 {
            font-size: 14pt;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .title .nomor {
            font-size: 10pt;
            margin-top: 5px;
        }

        .content {
            margin: 20px 0;
        }

        .content p {
            text-align: justify;
            margin-bottom: 10px;
        }

        .student-table {
            margin: 15px 0 15px 40px;
        }

        .student-table td {
            padding: 3px 10px;
            vertical-align: top;
        }

        .student-table td:first-child {
            width: 160px;
        }

        .student-table td:nth-child(2) {
            width: 15px;
            text-align: center;
        }

        .footer {
            margin-top: 40px;
        }

        .signature {
            float: right;
            text-align: center;
            width: 250px;
        }

        .signature .date {
            margin-bottom: 5px;
        }

        .signature .name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 80px;
        }

        .signature .nip {
            font-size: 10pt;
        }

        .signature img {
            max-height: 70px;
            margin-top: 10px;
        }

        .token-box {
            margin-top: 120px;
            clear: both;
            border: 1px solid #ccc;
            padding: 8px 15px;
            display: inline-block;
            font-size: 9pt;
            color: #555;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="header clearfix">
        @if ($logo_path)
            <img src="{{ public_path('storage/' . $logo_path) }}" alt="Logo" class="logo">
        @endif
        <div>
            <div class="school-name">{{ $school_name }}</div>
            @if ($school_npsn)
                <div class="school-detail">NPSN: {{ $school_npsn }}</div>
            @endif
            @if ($school_address)
                <div class="school-detail">{{ $school_address }}</div>
            @endif
        </div>
    </div>

    {{-- Title --}}
    <div class="title">
        <h2>Surat Keterangan Lulus</h2>
        <div class="nomor">Nomor: SKL/{{ $student->nisn }}/{{ date('Y') }}</div>
    </div>

    {{-- Content --}}
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala {{ $school_name }}, menerangkan bahwa:</p>

        <table class="student-table">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><strong>{{ $student->name }}</strong></td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>:</td>
                <td>{{ $student->nisn }}</td>
            </tr>
            @if ($student->nis)
                <tr>
                    <td>NIS</td>
                    <td>:</td>
                    <td>{{ $student->nis }}</td>
                </tr>
            @endif
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $student->birth_date->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $student->class_name }}</td>
            </tr>
            @if ($graduation->gpa)
                <tr>
                    <td>Nilai Rata-rata</td>
                    <td>:</td>
                    <td>{{ number_format($graduation->gpa, 2) }}</td>
                </tr>
            @endif
        </table>

        <p>Berdasarkan hasil evaluasi pembelajaran, peserta didik tersebut di atas telah dinyatakan:</p>

        <p style="text-align: center; font-size: 18pt; font-weight: bold; margin: 20px 0; letter-spacing: 3px;">
            L U L U S
        </p>

        <p>dari {{ $school_name }} Tahun Pelajaran {{ date('Y') - 1 }}/{{ date('Y') }}.</p>

        <p>Surat Keterangan Lulus ini diberikan kepada yang bersangkutan untuk digunakan sebagaimana mestinya.</p>
    </div>

    {{-- Signature --}}
    <div class="footer clearfix">
        <div class="signature">
            <div class="date">{{ now()->translatedFormat('d F Y') }}</div>
            <div>Kepala Sekolah,</div>
            @if ($signature_path)
                <img src="{{ public_path('storage/' . $signature_path) }}" alt="Tanda Tangan">
            @endif
            <div class="name">{{ $principal_name }}</div>
            @if ($principal_nip)
                <div class="nip">NIP. {{ $principal_nip }}</div>
            @endif
        </div>
    </div>

    {{-- Token Verification --}}
    <div class="token-box">
        Token Verifikasi: <strong>{{ $graduation->token }}</strong>
        <br>
        Dokumen ini dapat diverifikasi menggunakan token di atas.
    </div>
</body>

</html>
