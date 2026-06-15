<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ProYouth Report PDF - {{ $typeName }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 14pt;
            margin: 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 11pt;
            margin: 5px 0 0 0;
            text-transform: uppercase;
        }
        .header p {
            font-size: 9pt;
            margin: 5px 0 0 0;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 9pt;
        }
        .meta-table td {
            padding: 3px 0;
        }
        .meta-right {
            text-align: right;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .content-table th {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 8px 6px;
            font-size: 8pt;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
        }
        .content-table td {
            border: 1px solid #ccc;
            padding: 6px;
            font-size: 9pt;
        }
        .text-center {
            text-align: center;
        }
        .font-semibold {
            font-weight: bold;
        }
        .footer-section {
            margin-top: 50px;
            width: 100%;
        }
        .footer-section td {
            width: 50%;
            font-size: 9pt;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            width: 200px;
            text-align: center;
            font-weight: bold;
        }
        .signature-title {
            text-align: center;
            width: 200px;
            font-size: 8pt;
            color: #666;
            margin-top: 3px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>District Secretariat - Trincomalee</h1>
    <h2>ProYouth Program</h2>
    <p>{{ $typeName }} Selected Participants Report</p>
</div>

<table class="meta-table">
    <tr>
        <td><strong>Competition:</strong> {{ $typeName }}</td>
        <td class="meta-right"><strong>Total Selected:</strong> {{ count($selected) }}</td>
    </tr>
    <tr>
        <td><strong>Program Name:</strong> ProYouth Program</td>
        <td class="meta-right"><strong>Generated Date:</strong> {{ date('Y-m-d H:i') }}</td>
    </tr>
</table>

<table class="content-table">
    <thead>
        <tr>
            <th style="width: 25%;">Participant Name</th>
            <th style="width: 15%;">NIC Number</th>
            <th style="width: 8%; text-align: center;">Age</th>
            <th style="width: 18%;">DS Division</th>
            <th style="width: 20%;">Institute / School</th>
            <th style="width: 14%; text-align: center;">Marks</th>
        </tr>
    </thead>
    <tbody>
        @forelse($selected as $item)
            @php
                $participant = $item->proyouth;
            @endphp
            @if($participant)
                <tr>
                    <td class="font-semibold">{{ $participant->name }}</td>
                    <td>{{ $participant->nic_number }}</td>
                    <td class="text-center">{{ $participant->age }}</td>
                    <td>{{ $participant->ds_division }}</td>
                    <td>{{ $participant->institute_school }}</td>
                    <td class="text-center font-semibold">{{ $item->marks }}/100 @if($item->is_winner) (W) @endif</td>
                </tr>
            @endif
        @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #777;">
                    No selected participants found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<table class="footer-section">
    <tr>
        <td>
            <div class="signature-line">Prepared By</div>
            <div class="signature-title">PDO Officer</div>
        </td>
        <td style="text-align: right;">
            <div class="signature-line" style="margin-left: auto;">Approved By</div>
            <div class="signature-title" style="margin-left: auto;">District Secretary / Representative</div>
        </td>
    </tr>
</table>

</body>
</html>
