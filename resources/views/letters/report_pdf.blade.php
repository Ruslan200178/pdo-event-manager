<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Letter Report PDF - {{ $letter->reference_number }}</title>
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
        .signature-table {width: 100%; margin-top: 4rem; border-collapse: collapse;}
        .signature-table td {vertical-align: top; font-size: 0.9rem;}
    </style>
</head>
<body>
    <div class="header">
        <h1>National Productivity Secretariat</h1>
        <h2>District Secretariat - Trincomalee</h2>
        <p>Received Letter Correspondence Report</p>
    </div>

    <table class="meta-table">
        <tr>
            <td width="50%"><strong>Reference Number:</strong> {{ $letter->reference_number }}</td>
            <td width="50%" align="right"><strong>Sender Institution:</strong> {{ $letter->institution }}</td>
        </tr>
        <tr>
            <td width="50%"><strong>Received Date:</strong> {{ date('Y-m-d', strtotime($letter->date)) }}</td>
            <td width="50%" align="right"><strong>Action Deadline:</strong> 
                @if($letter->deadline)
                    {{ date('Y-m-d', strtotime($letter->deadline)) }}
                @else
                    None
                @endif
            </td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td width="50%" align="right"><strong>Report Generated:</strong> {{ date('Y-m-d') }}</td>
        </tr>
    </table>

    <div class="section">
        <h3>1. Subject / Description</h3>
        <div class="content-box">{{ $letter->subject }}</div>
    </div>
</body>
</html>
