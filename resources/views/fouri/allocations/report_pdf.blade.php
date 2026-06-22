<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Allocation Report PDF - {{ $allocation->id }}</title>
    <style>
        body {font-family: Arial, sans-serif; font-size: 11pt; color: #000; background: #fff; line-height: 1.4;}
        .header {text-align: center; border-bottom: 2px solid #000; padding-bottom: 0.5rem; margin-bottom: 1.5rem;}
        .header h1 {font-size: 1.3rem; margin: 0; text-transform: uppercase;}
        .header h2 {font-size: 1.1rem; margin: 5px 0 0 0; text-transform: uppercase;}
        .header p {font-size: 0.85rem; margin: 5px 0 0 0; color: #555; text-transform: uppercase; letter-spacing: 1px;}
        .meta-table {width: 100%; border-collapse: collapse; margin-bottom: 1.5rem;}
        .meta-table td {padding: 4px 0;}
        .section {margin-top: 1.5rem;}
        .section h3 {font-size: 0.95rem; text-transform: uppercase; border-bottom: 1px solid #555; padding-bottom: 0.2rem; margin-bottom: 0.5rem;}
        .content-box {background: #fcfcfc; border: 1px solid #ccc; padding: 10px; font-size: 0.95rem; white-space: pre-line;}
        .photo-table {width: 100%; margin-top: 1rem;}
        .photo-table td {padding: 6px; text-align: center; border: 1px solid #ddd;}
        .photo-img {width: 250px; height: 160px; object-cover: true;}
        .signature-table {width: 100%; margin-top: 3rem; border-collapse: collapse;}
        .signature-table td {vertical-align: top; font-size: 0.9rem;}
    </style>
</head>
<body>
    <div class="header">
        <h1>National Productivity Secretariat</h1>
        <h2>District Secretariat - Trincomalee</h2>
        <p>4i Project Initiative Allocation Report</p>
    </div>

    <table class="meta-table">
        <tr>
            <td width="50%"><strong>Division:</strong> {{ $allocation->division_name }}</td>
            <td width="50%" align="right"><strong>Amount:</strong> LKR {{ number_format($allocation->amount, 2) }}</td>
        </tr>
        <tr>
            <td width="50%"><strong>Date:</strong> {{ date('Y-m-d', strtotime($allocation->date)) }}</td>
            <td width="50%" align="right"><strong>Participants:</strong> {{ $allocation->participants_count }}</td>
        </tr>
        <tr>
            <td width="50%"><strong>Program Type:</strong> {{ $allocation->program_type }}</td>
            <td width="50%" align="right"><strong>Report Generated:</strong> {{ date('Y-m-d') }}</td>
        </tr>
    </table>

    <div class="section">
        <h3>1. Purpose of Allocation</h3>
        <div class="content-box">{{ $allocation->purpose }}</div>
    </div>

    @if($allocation->images && $allocation->images->count() > 0)
        <div class="section" style="page-break-inside: avoid;">
            <h3>2. Event Gallery</h3>
            <table class="photo-table">
                @foreach($allocation->images->chunk(2) as $chunk)
                    <tr>
                        @foreach($chunk as $img)
                            @php
                                $imgRelativePath = 'storage/' . $img->image_path;
                                $imgAbsolutePath = public_path($imgRelativePath);
                            @endphp
                            <td>
                                @if(file_exists($imgAbsolutePath))
                                    <img src="{{ $imgAbsolutePath }}" class="photo-img" alt="photo">
                                @else
                                    <div style="width: 250px; height: 160px; background: #eee; border: 1px solid #ccc; line-height: 160px; text-align: center; color: #777;">
                                        Photo Not Found
                                    </div>
                                @endif
                            </td>
                        @endforeach
                        @if($chunk->count() < 2)
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

</body>
</html>
