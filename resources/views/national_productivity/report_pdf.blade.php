<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPC Report PDF - {{ $program->vote_number }}</title>
    <style>
        body {font-family: Arial, sans-serif; font-size: 12pt; color: #000; background: #fff;}
        .header {text-align: center; margin-bottom: 1rem;}
        .header h1 {font-size: 1.2rem; margin: 0;}
        .header h2 {font-size: 1rem; margin: 0;}
        .section {margin-top: 1rem;}
        .section h3 {font-size: 0.9rem; text-transform: uppercase; border-bottom: 1px solid #555; padding-bottom: 0.2rem;}
        .grid {display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;}
        .box {border: 1px solid #ccc; padding: 0.5rem;}
        ul {margin: 0; padding-left: 1.2rem;}
    </style>
</head>
<body>
<div class="header">
    <h1>National Productivity Secretariat</h1>
    <h2>District Secretary</h2>
    <p>National Productivity Competition Evaluation Report</p>
</div>
<div class="grid">
    <div>
        <p><strong>Vote Number:</strong> {{ $program->vote_number }}</p>
        <p><strong>Conducted Date:</strong> {{ $program->conducted_date }}</p>
        <p><strong>Venue / Place:</strong> {{ $program->place }}</p>
    </div>
    <div style="text-align: right;">
        <p><strong>Allocation Amount:</strong> LKR {{ number_format($program->amount, 2) }}</p>
        <p><strong>Received Allocation:</strong> {{ $program->received_allocation }}</p>
        <p><strong>Report Generated:</strong> {{ date('Y-m-d') }}</p>
    </div>
</div>

<div class="section">
    <h3>1. Attendance & Participation Breakdown</h3>
    <table width="100%" style="border-collapse: collapse;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th style="border: 1px solid #ccc; padding: 4px;">Sector</th>
                <th style="border: 1px solid #ccc; padding: 4px; text-align: right;">Participants</th>
                <th style="border: 1px solid #ccc; padding: 4px; text-align: right;">Share (%)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = $program->participants_public + $program->participants_school + $program->participants_private;
                $publicPct = $total > 0 ? round(($program->participants_public / $total) * 100, 1) : 0;
                $schoolPct = $total > 0 ? round(($program->participants_school / $total) * 100, 1) : 0;
                $privatePct = $total > 0 ? round(($program->participants_private / $total) * 100, 1) : 0;
            @endphp
            <tr>
                <td style="border: 1px solid #ccc; padding: 4px;">Public Sector Staff</td>
                <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">{{ $program->participants_public }}</td>
                <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">{{ $publicPct }}%</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding: 4px;">School / Students Sector</td>
                <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">{{ $program->participants_school }}</td>
                <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">{{ $schoolPct }}%</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding: 4px;">Private Sector Stakeholders</td>
                <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">{{ $program->participants_private }}</td>
                <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">{{ $privatePct }}%</td>
            </tr>
            <tr style="font-weight: bold; background: #f0f0f0;">
                <td style="border: 1px solid #ccc; padding: 4px;">Total Program Participants</td>
                <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">{{ $total }}</td>
                <td style="border: 1px solid #ccc; padding: 4px; text-align: right;">100.0%</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="section">
    <h3>2. Public Sector Performance</h3>
    <div class="grid">
        <div class="box">
            <p class="font-semibold" style="margin: 0 0 0.5rem 0;">Application Status</p>
            <ul>
                <li>Total Applications Received: <strong>{{ $program->public_applications_count }}</strong></li>
                <li>Selected for Evaluation: <strong>{{ $program->public_selected_count }}</strong></li>
                <li>Selection Ratio: <strong>{{ $program->public_applications_count > 0 ? round(($program->public_selected_count / $program->public_applications_count) * 100, 1) : 0 }}%</strong></li>
            </ul>
        </div>
        <div class="box">
            <p class="font-semibold" style="margin: 0 0 0.5rem 0;">Commentation Summary</p>
            <ul>
                <li>Special Commentation Count: <strong>{{ $program->special_commentation_count }}</strong></li>
                <li>Commentation Count: <strong>{{ $program->commentation_count }}</strong></li>
            </ul>
        </div>
    </div>
</div>

<div class="section">
    <h3>3. School Sector Performance</h3>
    <div class="grid">
        <div class="box">
            <p class="font-semibold" style="margin: 0 0 0.5rem 0;">Application Status</p>
            <ul>
                <li>Total Applications Received: <strong>{{ $program->school_applications_count }}</strong></li>
                <li>Selected for Evaluation: <strong>{{ $program->school_selected_count }}</strong></li>
                <li>Selection Ratio: <strong>{{ $program->school_applications_count > 0 ? round(($program->school_selected_count / $program->school_applications_count) * 100, 1) : 0 }}%</strong></li>
            </ul>
        </div>
        <div class="box">
            <p class="font-semibold" style="margin: 0 0 0.5rem 0;">Commentation Summary</p>
            <ul>
                <li>Special Commentation Count: <strong>{{ $program->school_special_commentation_count }}</strong></li>
                <li>Commentation Count: <strong>{{ $program->school_commentation_count }}</strong></li>
            </ul>
        </div>
    </div>
</div>

<div class="section">
    <h3>4. Public Sector Placements & Awards</h3>
    <table width="100%" style="border-collapse: collapse; text-align: center;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th style="border: 1px solid #ccc; padding: 6px;">Placement</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Count</th>
                <th style="border: 1px solid #ccc; padding: 6px; text-align: left;">Winner Institute(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold; background: #fffdf5;">1st Place</td>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold;">{{ $program->place_1st_count }}</td>
                <td style="border: 1px solid #ccc; padding: 6px; text-align: left;">
                    @if(trim($program->public_place_1st_institute))
                        <ul style="margin: 0; padding-left: 1.2rem; list-style-type: disc;">
                            @foreach(array_filter(array_map('trim', explode(',', $program->public_place_1st_institute))) as $inst)
                                <li>{{ $inst }}</li>
                            @endforeach
                        </ul>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold; background: #fafafa;">2nd Place</td>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold;">{{ $program->place_2nd_count }}</td>
                <td style="border: 1px solid #ccc; padding: 6px; text-align: left;">
                    @if(trim($program->public_place_2nd_institute))
                        <ul style="margin: 0; padding-left: 1.2rem; list-style-type: disc;">
                            @foreach(array_filter(array_map('trim', explode(',', $program->public_place_2nd_institute))) as $inst)
                                <li>{{ $inst }}</li>
                            @endforeach
                        </ul>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold; background: #fffcf9;">3rd Place</td>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold;">{{ $program->place_3rd_count }}</td>
                <td style="border: 1px solid #ccc; padding: 6px; text-align: left;">
                    @if(trim($program->public_place_3rd_institute))
                        <ul style="margin: 0; padding-left: 1.2rem; list-style-type: disc;">
                            @foreach(array_filter(array_map('trim', explode(',', $program->public_place_3rd_institute))) as $inst)
                                <li>{{ $inst }}</li>
                            @endforeach
                        </ul>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="section">
    <h3>5. School Sector Placements & Awards</h3>
    <table width="100%" style="border-collapse: collapse; text-align: center;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th style="border: 1px solid #ccc; padding: 6px;">Placement</th>
                <th style="border: 1px solid #ccc; padding: 6px;">Count</th>
                <th style="border: 1px solid #ccc; padding: 6px; text-align: left;">Winner School(s)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold; background: #fffdf5;">1st Place</td>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold;">{{ $program->school_place_1st_count }}</td>
                <td style="border: 1px solid #ccc; padding: 6px; text-align: left;">
                    @if(trim($program->school_place_1st_institute))
                        <ul style="margin: 0; padding-left: 1.2rem; list-style-type: disc;">
                            @foreach(array_filter(array_map('trim', explode(',', $program->school_place_1st_institute))) as $inst)
                                <li>{{ $inst }}</li>
                            @endforeach
                        </ul>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold; background: #fafafa;">2nd Place</td>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold;">{{ $program->school_place_2nd_count }}</td>
                <td style="border: 1px solid #ccc; padding: 6px; text-align: left;">
                    @if(trim($program->school_place_2nd_institute))
                        <ul style="margin: 0; padding-left: 1.2rem; list-style-type: disc;">
                            @foreach(array_filter(array_map('trim', explode(',', $program->school_place_2nd_institute))) as $inst)
                                <li>{{ $inst }}</li>
                            @endforeach
                        </ul>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold; background: #fffcf9;">3rd Place</td>
                <td style="border: 1px solid #ccc; padding: 6px; font-weight: bold;">{{ $program->school_place_3rd_count }}</td>
                <td style="border: 1px solid #ccc; padding: 6px; text-align: left;">
                    @if(trim($program->school_place_3rd_institute))
                        <ul style="margin: 0; padding-left: 1.2rem; list-style-type: disc;">
                            @foreach(array_filter(array_map('trim', explode(',', $program->school_place_3rd_institute))) as $inst)
                                <li>{{ $inst }}</li>
                            @endforeach
                        </ul>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
