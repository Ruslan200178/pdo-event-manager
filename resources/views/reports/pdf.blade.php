<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report->title }} - Printable PDF Report</title>
    <!-- Outfit Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #ffffff;
            color: #1f2937;
            padding: 2.5rem;
            margin: 0;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #11194b;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }
        .header h1 {
            color: #11194b;
            font-size: 1.8rem;
            margin: 0 0 0.5rem 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 0.2rem 0;
            font-size: 0.85rem;
            color: #4b5563;
        }
        .report-meta {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin-bottom: 2rem;
            display: grid;
            grid-template-cols: repeat(2, 1fr);
            gap: 1rem;
            font-size: 0.85rem;
        }
        .meta-item {
            margin-bottom: 0.5rem;
        }
        .meta-item strong {
            color: #11194b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2.5rem;
            font-size: 0.85rem;
        }
        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background-color: #f1f5f9;
            color: #11194b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
        }
        tr:hover {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 5rem;
            border-top: 1px solid #e2e8f0;
            padding-top: 1rem;
            text-align: center;
            font-size: 0.75rem;
            color: #9ca3af;
        }
        .no-print {
            text-align: right;
            margin-bottom: 1.5rem;
        }
        .print-btn {
            background-color: #11194b;
            color: #ffffff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            transition: background-color 0.15s;
        }
        .print-btn:hover {
            background-color: #1d2c7b;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Print Control Bar -->
    <div class="no-print">
        <button onclick="window.print()" class="print-btn">
            <span style="margin-right: 5px;">🖨️</span> Print Document
        </button>
    </div>

    <!-- Government Header -->
    <div class="header">
        <h1>Democratic Socialist Republic of Sri Lanka</h1>
        <p>Divisional Secretariat Office - Productivity Development & Event Management Division</p>
        <p style="font-weight: 600; color: #11194b; font-size: 1rem; margin-top: 0.75rem;">Official Productivity Progress Report</p>
    </div>

    <!-- Report Metadata -->
    <div class="report-meta" style="display: flex; justify-content: space-between;">
        <div class="meta-item">
            <strong>Report Title:</strong> {{ $report->title }}<br>
            <strong>Reporting cycle:</strong> {{ $report->type }}<br>
        </div>
        <div class="meta-item" style="text-align: right;">
            <strong>Reference Date:</strong> {{ $report->date }}<br>
            <strong>Generated At:</strong> {{ $report->created_at->format('Y-m-d h:i A') }}
        </div>
    </div>

    <!-- Metrics Table -->
    <table>
        <thead>
            <tr>
                <th>Productivity Metric Area</th>
                <th class="text-right">Recorded Count / Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>National Productivity Competitions (NPC) logged</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['national_productivity_competitions_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Community Model Villages (CMV) monitored</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['community_model_villages_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Citizen Mirror Survey records</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['citizen_mirror_entries_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>ProYouth AI Video entries</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['proyouth_videos_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>ProYouth Project Proposals submitted</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['proyouth_proposals_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>5S certification audits logged</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['five_s_certifications_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>5S certified workspace units</td>
                <td class="text-right" style="font-weight: 600; color: #059669;">{{ $data['five_s_certified_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Active Certification Courses</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['certification_courses_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Total Enrolled Students count</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['total_students_enrolled'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Conducting Training Programs</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['training_programs_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Total Training Program Participants</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['training_participants_total'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Registered Divisional Productivity Officers</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['registered_officers_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>4i Project Allocations</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['allocations_count'] ?? 0 }}</td>
            </tr>
            <tr>
                <td>Letter Management</td>
                <td class="text-right" style="font-weight: 600;">{{ $data['letters_count'] ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Sign-off Block -->
    <div style="margin-top: 6rem; display: flex; justify-content: space-between;">
        <div style="border-top: 1px solid #9ca3af; width: 200px; text-align: center; padding-top: 0.5rem; font-size: 0.8rem;">
            Prepared By (PDO)
        </div>
        <div style="border-top: 1px solid #9ca3af; width: 200px; text-align: center; padding-top: 0.5rem; font-size: 0.8rem;">
            Approved By (DS)
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        © {{ date('Y') }} Divisional Secretariat Office. Certified Official Document.
    </div>

</body>
</html>
