<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
}

.report-container {
    background: white;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.report-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    padding: 25px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-logo {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 24px;
}

.header-title {
    flex: 1;
}

.header-title h2 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 4px;
}

.header-title p {
    font-size: 13px;
    opacity: 0.95;
}

.header-date {
    text-align: right;
}

.header-date p {
    font-size: 12px;
    margin-bottom: 3px;
    opacity: 0.9;
}

.header-date .date-value {
    font-weight: 600;
    font-size: 13px;
}

.table-wrapper {
    overflow-x: auto;
    padding: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    font-size: 12px;
}

table thead {
    background: #1e3a8a;
    color: white;
    position: sticky;
    top: 0;
}

table th {
    padding: 14px 10px;
    text-align: center;
    font-weight: 600;
    font-size: 11px;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    border: 1px solid #1e3a8a;
    background: #1e3a8a;
}

table td {
    padding: 11px 10px;
    text-align: center;
    border: 1px solid #e5e7eb;
    font-size: 12px;
}

table tbody tr {
    transition: background-color 0.15s ease;
    border-bottom: 1px solid #e5e7eb;
}

table tbody tr:hover {
    background-color: #f3f4f6;
}

.dept-header {
    background: #2563eb;
    color: white;
    font-weight: 700;
}

.dept-header td {
    border-color: #2563eb;
    text-align: left;
    padding: 12px;
}

.group-name-cell {
    text-align: left;
    font-weight: 500;
    color: #1f2937;
}

.time-cell {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #1f2937;
}

.percent-cell {
    background: #dbeafe;
    color: #1e40af;
    font-weight: 700;
}

.total-cell {
    background: #1e40af;
    color: white;
    font-weight: 700;
}

.empty-cell {
    color: #9ca3af;
}

.footer-section {
    padding: 20px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    text-align: center;
    font-size: 11px;
    color: #6b7280;
}

.footer-legend {
    display: flex;
    gap: 25px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 12px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
}

.legend-dot {
    width: 10px;
    height: 10px;
    border-radius: 2px;
    display: inline-block;
}

.dot-duration {
    background: #2563eb;
}

.dot-percentage {
    background: #dbeafe;
}

.dot-total {
    background: #1e40af;
}

@media print {
    body {
        background: white;
        padding: 0;
    }

    .report-container {
        box-shadow: none;
    }

    table {
        font-size: 10px;
        page-break-inside: avoid;
    }

    table th,
    table td {
        padding: 5px;
    }

    .footer-section {
        display: none;
    }

    @page {
        size: A3 landscape;
        margin: 10mm;
    }
}

@media (max-width: 768px) {
    .report-header {
        flex-direction: column;
        text-align: center;
    }

    .header-left {
        flex-direction: column;
        width: 100%;
    }

    .header-date {
        text-align: center;
        width: 100%;
    }

    table {
        font-size: 10px;
    }

    table th,
    table td {
        padding: 8px 5px;
    }
}
</style>

<div class="report-container">
    <div class="report-header">
        <div class="header-left">
            <div class="header-logo"><img src="{{asset('images/logo.jpg')}}" class="img-responsive"></div>
            <div class="header-title">
                <h2>Monthly Report on Breakdowns</h2>
                <p>For the Period From {{$start_date}} To {{$end_date}}</p>
            </div>
        </div>
        <div class="header-date">
            <p>Period</p>
            <p class="date-value">{{$start_date}} to {{$end_date}}</p>
        </div>
    </div>

    <div class="table-wrapper">
        <table border="1" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th rowspan="3" style="width: 200px;">Group Name</th>
                    <?php foreach ($data_break as $k => $v) { ?>
                    <th colspan="2">{{$v->breakdown_name}}</th>
                    <?php } ?>
                    <th colspan="2">Overall Total</th>
                </tr>
                <tr>
                    <?php foreach ($data_break as $k => $v) { ?>
                    <th style="width: 90px;">Duration<br>(HH:MM)</th>
                    <th style="width: 80px;">Percentage (%)</th>
                    <?php } ?>
                    <th style="width: 90px;">Duration<br>(HH:MM)</th>
                    <th style="width: 80px;">Percentage (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
        if (isset($data) && count($data) > 0) {
    foreach ($data_department as $key => $value) {
        $kk = 0;
        foreach ($data as $k => $v) {
            if ($v->department_id == $value->department_id) {
                if ($kk == 0) {
                    $kk = 1;
                    echo "<tr class='dept-header'>";
                    echo "<td colspan='20' style='text-align: left;'>";
                    echo "<strong>Department: {{$value->department_name}}</strong>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td class='group-name-cell'>{{$v->group_name}}</td>";

                foreach ($data_break as $k1 => $v1) {
                    $id = "typesum" . $v1->breakdowntype_id;
                    $id1 = "percent" . $v1->breakdowntype_id;

                    $time_val = ($v->$id == '00:00:00.000000' || empty($v->$id)) ? '—' : $v->$id;
                    $percent_val = ($v->$id1 == '00:00:00.000000' || empty($v->$id1)) ? '—' : $v->$id1;

                    echo "<td class='time-cell'>" . $time_val . "</td>";
                    echo "<td class='percent-cell'>" . $percent_val . "</td>";
                }

                $total_val = ($v->total == '00:00:00.000000' || empty($v->total)) ? '—' : $v->total;
                $percent_total = (empty($v->percenttotal)) ? '—' : $v->percenttotal;

                echo "<td class='total-cell'>" . $total_val . "</td>";
                echo "<td class='total-cell'>" . $percent_total . "</td>";
                echo "</tr>";
            }
        }
    }
} else {
    echo "<tr><td colspan='20' style='text-align: center; padding: 40px; color: #999;'>No breakdown data available</td></tr>";
}
        ?>
            </tbody>
        </table>
    </div>

    <div class="footer-section">
        <strong>Report Information:</strong>
        <div class="footer-legend">
            <div class="legend-item">
                <span class="legend-dot dot-duration"></span>
                <span><strong>Duration</strong> = Time spent in breakdown</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot dot-percentage"></span>
                <span><strong>Percentage (%)</strong> = Percentage of total working hours</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot dot-total"></span>
                <span><strong>Overall Total</strong> = Sum of all breakdown types</span>
            </div>
        </div>
        <p style="margin-top: 10px; font-size: 10px; color: #999;">
            Report generated on <span id="footerDate"></span> | A3 Landscape format recommended for printing
        </p>
    </div>
</div>