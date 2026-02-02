<?php
$year = $year;
$yr = substr($year, -2);
$month = array(
    "1" => "JAN-" . $yr,
    "2" => "Feb-" . $yr,
    "3" => "Mar-" . $yr,
    "4" => "Apr-" . $yr,
    "5" => "May-" . $yr,
    "6" => "Jun-" . $yr,
    "7" => "Jul-" . $yr,
    "8" => "Aug-" . $yr,
    "9" => "Sept-" . $yr,
    "10" => "Oct-" . $yr,
    "11" => "Nov-" . $yr,
    "12" => "Dec-" . $yr
);
?>

<!DOCTYPE html>
<html>

<head>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f7fa;
    }

    .report-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .report-header {
        background: linear-gradient(135deg, #1e5a96 0%, #2c7fb8 100%);
        padding: 30px;
        color: white;
        text-align: center;
    }

    .report-header img {
        max-width: 150px;
        height: auto;
        margin-bottom: 15px;
    }

    .report-header h4 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
        line-height: 1.5;
    }

    .report-header p {
        font-size: 13px;
        opacity: 0.95;
        line-height: 1.6;
        margin-bottom: 4px;
    }

    .report-title {
        font-size: 16px;
        font-weight: 600;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid rgba(255, 255, 255, 0.3);
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
    }

    table thead {
        background: linear-gradient(135deg, #1e5a96 0%, #2c7fb8 100%);
        color: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    table th {
        padding: 15px 10px;
        text-align: center;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: 1px solid #1e5a96;
    }

    table td {
        padding: 12px 10px;
        text-align: center;
        border: 1px solid #e0e6ed;
        font-size: 12px;
    }

    table tbody tr {
        transition: background-color 0.2s ease;
    }

    table tbody tr:hover {
        background-color: #f8f9ff;
    }

    table tbody tr:nth-child(4n+1),
    table tbody tr:nth-child(4n+2) {
        background-color: #fafbfc;
    }

    .sno-cell {
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        font-weight: 700;
        color: #1e5a96;
        width: 60px;
    }

    .machine-cell {
        text-align: left;
        font-weight: 500;
        color: #2c3e50;
        word-break: break-word;
        min-width: 200px;
    }

    .row-label {
        background: #f0f3f7;
        font-weight: 600;
        color: #1e5a96;
    }

    .plan-cell {
        position: relative;
        padding: 8px;
    }

    .plan-icon {
        width: 24px;
        height: 24px;
        display: inline-block;
        opacity: 0.8;
        transition: all 0.2s ease;
    }

    .plan-icon:hover {
        opacity: 1;
        transform: scale(1.15);
    }

    .actual-date {
        background-color: #d4edda;
        color: #155724;
        font-weight: 600;
        padding: 6px 8px;
        border-radius: 4px;
        display: inline-block;
        min-width: 35px;
    }

    .tooltip-wrapper {
        position: relative;
        display: inline-block;
        cursor: help;
    }

    .tooltip-text {
        visibility: hidden;
        width: 90px;
        background-color: #2c3e50;
        color: white;
        text-align: center;
        padding: 8px 10px;
        border-radius: 4px;
        position: absolute;
        z-index: 20;
        bottom: 125%;
        left: 50%;
        margin-left: -45px;
        opacity: 0;
        transition: opacity 0.3s ease;
        font-size: 11px;
        white-space: nowrap;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.25);
    }

    .tooltip-text::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #2c3e50 transparent transparent transparent;
    }

    .tooltip-wrapper:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    .empty-row {
        background-color: #fff;
        color: #bdc3c7;
        font-style: italic;
    }

    .week-header {
        background-color: #1e5a96;
        color: white;
        font-weight: 700;
    }

    .footer-note {
        padding: 20px;
        text-align: center;
        font-size: 12px;
        color: #7f8c8d;
        border-top: 1px solid #e0e6ed;
        background: #f8f9fa;
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
            background: #1e5a96 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        table thead {
            background: #1e5a96 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .actual-date {
            background-color: #90EE90 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @page {
            size: A3;
            margin: 15mm;
        }

        table {
            font-size: 10px;
            page-break-inside: avoid;
        }

        .footer-note {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .report-header {
            padding: 20px;
        }

        .report-header h4 {
            font-size: 14px;
        }

        table th {
            padding: 10px 5px;
            font-size: 10px;
        }

        table td {
            padding: 8px 5px;
            font-size: 10px;
        }

        .machine-cell {
            min-width: 150px;
        }

        .plan-icon {
            width: 20px;
            height: 20px;
        }
    }
    </style>
</head>

<body>
    <div class="report-container">
        <div class="report-header">
            <img src='../public/images/logo.jpg' alt='Company Logo'>
            <h3>L&T Construction</h3>
            <p>POWER TRANSMISSION & DISTRIBUTION</p>
            <p>TLT-PONDICHERRY, PITHAMPUR & KANCHIPURAM UNITS</p>
            <p>QUALITY, ENVIRONMENT, HEALTH & SAFETY MANAGEMENT SYSTEM</p>
            <div class="report-title">PREVENTIVE MAINTENANCE SCHEDULE - {{$year}}</div>
        </div>

        <div class="table-wrapper">
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th rowspan="3">SNO</th>
                        <th rowspan="3">Machine Number & Code</th>
                        <th colspan="8" class="week-header">Monthly Schedule</th>
                    </tr>
                    <tr>
                        <th colspan="4">Planned Week</th>
                        <th colspan="4">Actual Completion</th>
                    </tr>
                    <tr>
                        <th>W1</th>
                        <th>W2</th>
                        <th>W3</th>
                        <th>W4</th>
                        <th>W1</th>
                        <th>W2</th>
                        <th>W3</th>
                        <th>W4</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sno = 1;
if (isset($machine_details) && count($machine_details) > 0) {
    foreach ($machine_details as $key => $value) {
        $machine_id = $value->machine_id;
                    ?>
                    <tr>
                        <td rowspan="2" class="sno-cell"><?php        echo $sno; ?></td>
                        <td rowspan="2" class="machine-cell">
                            <strong><?php        echo $value->asset_code; ?></strong><br>
                            <?php        echo $value->machine_name; ?>
                        </td>

                        <?php
        $no_of_weeks = 4;
        for ($i = 1; $i <= $no_of_weeks; $i++) {
            if (isset($data[$machine_id][$sele_mon][$i]) && !empty($data[$machine_id][$sele_mon][$i]['date'])) {
                echo "<td class='plan-cell'>";
                echo "<div class='tooltip-wrapper'>";
                echo "<img src='../public/images/plan.png' class='plan-icon' alt='Planned'>";
                echo "<span class='tooltip-text'>" . $data[$machine_id][$sele_mon][$i]['date'] . "</span>";
                echo "</div>";
                echo "</td>";
            } else {
                echo "<td class='empty-row'>—</td>";
            }
        }
                        ?>
                    </tr>
                    <tr class="row-label">
                        <td colspan="2" style="text-align: left;">ACTUAL COMPLETION DATE</td>
                        <?php
        for ($i = 1; $i <= $no_of_weeks; $i++) {
            if (isset($data[$machine_id][$sele_mon][$i]) && !empty($data[$machine_id][$sele_mon][$i]['done_date'])) {
                echo "<td><span class='actual-date'>" . $data[$machine_id][$sele_mon][$i]['done_date'] . "</span></td>";
            } else {
                echo "<td class='empty-row'>—</td>";
            }
        }
                        ?>
                    </tr>
                    <?php
        $sno++;
    }
} else {
    echo "<tr><td colspan='10' style='text-align: center; padding: 40px; color: #999;'>No data available for the selected period</td></tr>";
}
                    ?>
                </tbody>
            </table>
        </div>

        <div class="footer-note">
            Copyright © 2025 - IFIVE Techsol Pvt Ltd
        </div>
    </div>
</body>

</html>