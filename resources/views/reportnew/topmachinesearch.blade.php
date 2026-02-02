<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f7fa;
    padding: 20px;
}

.report-container {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.report-header {
    background: linear-gradient(135deg, #024d87 0%, #024d87 100%);
    padding: 40px 30px;
    color: white;
    text-align: center;
}

.report-header img {
    max-width: 100px;
    height: auto;
    margin-bottom: 15px;
}

.report-header h3 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
}

.report-header p {
    font-size: 14px;
    opacity: 0.95;
    margin-bottom: 4px;
}

.report-subtitle {
    background: rgba(255, 255, 255, 0.2);
    padding: 12px 20px;
    border-radius: 6px;
    margin-top: 15px;
    font-size: 13px;
    font-weight: 600;
    display: inline-block;
}

.table-wrapper {
    overflow-x: auto;
    padding: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    margin-bottom: 20px;
    font-size: 13px;
}

table thead {
    background: linear-gradient(135deg, #024d87 0%, #024d87 100%);
    color: white;
}

table th {
    padding: 16px 12px;
    text-align: center;
    font-weight: 700;
    font-size: 12px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    border: 1px solid #024d87;
}

table td {
    padding: 16px 12px;
    text-align: center;
    border: 1px solid #e0e6ed;
    font-size: 12px;
}

table tbody tr {
    transition: all 0.3s ease;
}

table tbody tr:hover {
    transform: scale(1.02);
    box-shadow: inset 0 0 8px rgba(102, 126, 234, 0.1);
}

/* Rank 1 - Gold */
table tbody tr:nth-child(1) {
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
    color: white;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(255, 216, 155, 0.3);
}

table tbody tr:nth-child(1) td {
    border-color: #ffd89b;
    color: white;
}

/* Rank 2 - Silver */
table tbody tr:nth-child(2) {
    background: linear-gradient(135deg, #e0e0e0 0%, #808080 100%);
    color: white;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(224, 224, 224, 0.3);
}

table tbody tr:nth-child(2) td {
    border-color: #e0e0e0;
    color: white;
}

/* Rank 3 - Bronze */
table tbody tr:nth-child(3) {
    background: linear-gradient(135deg, #cd7672 0%, #8b6f47 100%);
    color: white;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(205, 118, 114, 0.3);
}

table tbody tr:nth-child(3) td {
    border-color: #cd7672;
    color: white;
}

/* Other ranks */
table tbody tr:nth-child(n+4) {
    background-color: #fafbfc;
}

table tbody tr:nth-child(odd):nth-child(n+4) {
    background-color: #f5f7fa;
}

table tbody tr:nth-child(n+4):hover {
    background-color: #f0f3f7;
}

.machine-cell {
    text-align: left;
    font-weight: 600;
    padding-left: 20px;
}

table tbody tr:nth-child(1) .machine-cell,
table tbody tr:nth-child(2) .machine-cell,
table tbody tr:nth-child(3) .machine-cell {
    text-align: center;
    padding-left: 12px;
}

.dept-cell {
    text-align: left;
    padding-left: 16px;
}

table tbody tr:nth-child(1) .dept-cell,
table tbody tr:nth-child(2) .dept-cell,
table tbody tr:nth-child(3) .dept-cell {
    text-align: center;
    padding-left: 12px;
}

.count-cell {
    font-weight: 700;
    font-size: 14px;
}

.downtime-cell {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    font-size: 14px;
}

.rank-badge {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 900;
    font-size: 18px;
    text-align: center;
    margin-right: 8px;
    border: 2px solid rgba(255, 255, 255, 0.5);
}

table tbody tr:nth-child(n+4) .rank-badge {
    background: #024d87;
    color: white;
    border: none;
}

.footer-note {
    padding: 25px;
    text-align: center;
    font-size: 12px;
    color: #7f8c8d;
    border-top: 2px solid #e0e6ed;
    background: #f8f9fa;
}

.legend {
    display: flex;
    justify-content: center;
    gap: 25px;
    flex-wrap: wrap;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e0e6ed;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 600;
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 3px;
}

.gold {
    background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
}

.silver {
    background: linear-gradient(135deg, #e0e0e0 0%, #808080 100%);
}

.bronze {
    background: linear-gradient(135deg, #cd7672 0%, #8b6f47 100%);
}

@media print {
    body {
        background: white;
        padding: 0;
    }

    .report-container {
        box-shadow: none;
        border: 1px solid #ddd;
    }

    .report-header {
        background: #333 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    table thead {
        background: #333 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    table tbody tr:nth-child(1),
    table tbody tr:nth-child(2),
    table tbody tr:nth-child(3) {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    @page {
        size: A4;
        margin: 10mm;
    }

    table {
        font-size: 11px;
        page-break-inside: avoid;
    }

    table th,
    table td {
        padding: 8px;
        border: 0.5px solid #000;
    }

    tr {
        page-break-inside: avoid;
    }

    .footer-note {
        display: none;
    }
}

@media (max-width: 768px) {
    .report-header {
        padding: 25px 15px;
    }

    .report-header h3 {
        font-size: 22px;
    }

    .table-wrapper {
        padding: 15px;
    }

    table {
        font-size: 11px;
    }

    table th,
    table td {
        padding: 10px;
    }

    .machine-cell,
    .dept-cell {
        padding-left: 10px;
    }

    .legend {
        gap: 15px;
    }

    .legend-item {
        font-size: 10px;
    }
}
</style>

<div class="report-container">
    <div class="report-header">
        <img src="{{asset('images/logo.jpg')}}" alt='Company Logo'>
        <h3>Top 5 Breakdown Report</h3>
        <p>For the Period From <strong style="color:white">{{$start_date}}</strong> To <strong
                style="color:white">{{$end_date}}</strong></p>
        <div class="report-subtitle">
            🏆 Top 5 Machines by Breakdown Count & Downtime
        </div>
    </div>

    <div class="table-wrapper">
        <table border="1" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 200px;">Machine Name</th>
                    <th style="width: 180px;">Department</th>
                    <th style="width: 150px;">No. of Breakdowns</th>
                    <th style="width: 150px;">Downtime (Hrs)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
        $i = 1;
$totalCount = 0;

if (isset($data) && count($data) > 0) {
    foreach ($data as $k => $v) {
        $totalCount += $v->bids;

        $rankEmoji = '';
        if ($i == 1)
            $rankEmoji = '🥇';
        elseif ($i == 2)
            $rankEmoji = '🥈';
        elseif ($i == 3)
            $rankEmoji = '🥉';
        else
            $rankEmoji = '⭐';
            ?>
                <tr>
                    <td class="machine-cell">
                        <span class="rank-badge">{{$rankEmoji}}</span>{{$v->machine}}
                    </td>
                    <td class="dept-cell">{{$v->dept}}</td>
                    <td class="count-cell">{{$v->bids}}</td>
                    <td class="downtime-cell">{{$v->time_diff}}</td>
                </tr>
                <?php
        $i++;
    }
} else {
    echo "<tr><td colspan='4' style='text-align: center; padding: 40px; color: #999;'>No breakdown data available for the selected period</td></tr>";
}
        ?>
            </tbody>
        </table>

        <div class="footer-note">
            <strong>Report Information:</strong>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color gold"></div>
                    <span>Rank 1 - Highest Breakdowns</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color silver"></div>
                    <span>Rank 2 - Second Highest</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color bronze"></div>
                    <span>Rank 3 - Third Highest</span>
                </div>
                <div class="legend-item">
                    <strong>📊 Total in Top 5:</strong> <span
                        style="color: #024d87; font-weight: 700;">{{isset($totalCount) ? $totalCount : 0}}</span>
                </div>
            </div>
            <p style="margin-top: 15px; font-size: 11px; color: #999;">
                Report generated on <span id="footerDate"></span> | Rankings based on breakdown frequency and downtime
                duration | A4 format recommended
            </p>
        </div>
    </div>
</div>

<script>
// Set current date
var today = new Date();
var dateStr = (today.getMonth() + 1) + "/" + today.getDate() + "/" + today.getFullYear();
document.getElementById('footerDate').innerHTML = today.toLocaleString();
</script>