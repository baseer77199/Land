<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f7fa;
    /* padding: 20px; */
}

.report-container {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.report-header {
    background: linear-gradient(135deg, #024d87 0%, #024d87 100%);
    padding: 30px;
    color: white;
    text-align: center;
}

.report-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.report-header img {
    max-width: 120px;
    height: auto;
}

.report-title {
    flex: 1;
    min-width: 300px;
}

.report-title h3 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
}

.report-title p {
    font-size: 13px;
    opacity: 0.95;
    margin-bottom: 4px;
}

.report-date {
    text-align: right;
    min-width: 150px;
}

.report-date p {
    font-size: 12px;
    margin-bottom: 4px;
}

.table-wrapper {
    overflow-x: auto;
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    margin-bottom: 20px;
    font-size: 12px;
}

table thead {
    background: linear-gradient(135deg, #024d87 0%, #024d87 100%);
    color: white;
}

table th {
    padding: 12px 8px;
    text-align: center;
    font-weight: 600;
    font-size: 11px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    border: 1px solid #667eea;
}

table td {
    padding: 10px 8px;
    text-align: center;
    border: 1px solid #e0e6ed;
    font-size: 11px;
}

table tbody tr {
    transition: background-color 0.2s ease;
}

table tbody tr:hover {
    background-color: #f8f9ff;
}

table tbody tr:nth-child(odd) {
    background-color: #fafbfc;
}

.dept-header {
    background: linear-gradient(135deg, #667eea 0%, #024d87 100%));
    color: white;
    font-weight: 700;
}

.dept-header td {
    border-color: #667eea !important;
    padding: 12px !important;
}

.machine-name-cell {
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
}

.hours-cell {
    background: #e3f2fd;
    color: #1976d2;
    font-weight: 600;
}

.time-cell {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #2c3e50;
}

.freq-cell {
    background: #f3e5f5;
    color: #7b1fa2;
    font-weight: 700;
    border-radius: 3px;
    min-width: 30px;
}

.percent-cell {
    background: #d4edda;
    color: #155724;
    font-weight: 700;
}

.total-cell {
    background: #cce5ff;
    color: #004085;
    font-weight: 700;
}

.section-header {
    background: linear-gradient(135deg, #024d87 0%, #024d87 100%);
    color: white;
    font-weight: 700;
}

.section-header td {
    border-color: #667eea !important;
    padding: 12px !important;
}

.empty-cell {
    color: #bdc3c7;
    font-style: italic;
}

.footer-note {
    padding: 20px;
    text-align: center;
    font-size: 11px;
    color: #7f8c8d;
    border-top: 1px solid #e0e6ed;
    background: #f8f9fa;
}

.legend {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 10px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 10px;
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

    .dept-header,
    .section-header {
        background: #333 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .percent-cell,
    .total-cell,
    .freq-cell,
    .hours-cell {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    @page {
        size: A3 landscape;
        margin: 10mm;
    }

    table {
        font-size: 9px;
        page-break-inside: avoid;
    }

    table th,
    table td {
        padding: 4px;
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
    .report-header-content {
        flex-direction: column;
        text-align: center;
    }

    .report-date {
        text-align: center;
    }

    table {
        font-size: 10px;
    }

    table th,
    table td {
        padding: 6px 4px;
    }
}
</style>

<div class="report-container">
    <div class="report-header">
        <div class="report-header-content">
            <img src="{{asset('images/logo.jpg')}}" alt='Company Logo'>
            <div class="report-title">
                <h3>Monthly Report on Breakdowns</h3>

                <p>For the Period From <strong style="color:white;">{{$start_date}}</strong> To
                    <strong style="color:white;">{{$end_date}}</strong>
                </p>
            </div>
            <div class="report-date">
                <!-- <p><strong>Generated:</strong></p>
                <p id="currentDate"></p> -->
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table border="1" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th rowspan="3" style="width: 200px;">Machine Name</th>
                    <th rowspan="3" style="width: 90px;">Available<br>Hours</th>
                    <?php foreach ($data_break as $k => $v) { ?>
                    <th colspan="3" class="breakdown-type">{{$v->breakdown_name}}</th>
                    <?php } ?>
                    <th colspan="3" style="background: #024d87;">Overall Total</th>
                </tr>
                <tr>
                    <?php foreach ($data_break as $k => $v) { ?>
                    <th style="width: 70px;">Duration<br>(HH:MM)</th>
                    <th style="width: 50px;">Frequency</th>
                    <th style="width: 60px;">%</th>
                    <?php } ?>
                    <th style="width: 70px; background: #024d87; color: white;">Duration<br>(HH:MM)</th>
                    <th style="width: 50px; background: #024d87; color: white;">Frequency</th>
                    <th style="width: 60px; background: #024d87; color: white;">%</th>
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
                    echo "<td colspan='20' style='text-align: left; padding: 12px;'>";
                    echo "🏭 <strong>Department: {{$value->department_name}}</strong>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td class='machine-name-cell'>{{$v->machine}}</td>";
                echo "<td class='hours-cell'>{{$v->total_hrs}}</td>";

                foreach ($data_break as $k1 => $v1) {
                    $freq = "freq" . $v1->breakdowntype_id;
                    $id = "typesum" . $v1->breakdowntype_id;
                    $id1 = "percent" . $v1->breakdowntype_id;

                    $time_val = ($v->$id == '00:00:00.000000' || empty($v->$id)) ? '—' : $v->$id;
                    $freq_val = (empty($v->$freq) || $v->$freq == 0) ? '—' : $v->$freq;
                    $percent_val = ($v->$id1 == '00:00:00.000000' || empty($v->$id1)) ? '—' : $v->$id1;

                    echo "<td class='time-cell'>" . $time_val . "</td>";
                    echo "<td class='freq-cell'>" . $freq_val . "</td>";
                    echo "<td class='percent-cell'>" . $percent_val . "</td>";
                }

                $total_val = ($v->total == '00:00:00.000000' || empty($v->total)) ? '—' : $v->total;
                $total_freq = (empty($v->total_freq) || $v->total_freq == 0) ? '—' : $v->total_freq;
                $percent_total = (empty($v->percenttotal)) ? '—' : $v->percenttotal;

                echo "<td class='total-cell'>" . $total_val . "</td>";
                echo "<td class='total-cell'>" . $total_freq . "</td>";
                echo "<td class='total-cell'>" . $percent_total . "</td>";
                echo "</tr>";
            }
        }
    }
} else {
    echo "<tr><td colspan='20' style='text-align: center; padding: 40px; color: #999;'>No breakdown data available</td></tr>";
}
        ?>
                <tr class='section-header'>
                    <td colspan="2" style="text-align: left; padding: 12px;">⚡ ELECTRICITY CONSUMPTION (UNITS)</td>
                    <td colspan="8" style="text-align: center;">E.B. (Grid Supply)</td>
                    <td colspan="8" style="text-align: center;">D.G. (Diesel Generator)</td>
                </tr>
            </tbody>
        </table>

        <div class="footer-note">
            <strong>Report Information & Legend:</strong>
            <div class="legend">
                <div class="legend-item">
                    <strong style="color: #1976d2;">⏱️ Duration</strong> = Breakdown time (HH:MM)
                </div>
                <div class="legend-item">
                    <strong style="color: #7b1fa2;">📊 Frequency</strong> = Number of breakdowns
                </div>
                <div class="legend-item">
                    <strong style="color: #155724;">📈 Percentage (%)</strong> = % of available hours
                </div>
                <div class="legend-item">
                    <strong style="color: #004085;">🎯 Overall Total</strong> = Cumulative values
                </div>
            </div>
            <p style="margin-top: 10px; font-size: 10px; color: #999;">
                Report generated on <span id="footerDate"></span> | A3 Landscape format recommended for optimal printing
            </p>
        </div>
    </div>
</div>