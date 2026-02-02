<?php
$year = isset($year) ? $year : date('Y');
$yr = substr($year, -2);
$month1 = array(
    "01" => "JAN-" . $yr,
    "02" => "Feb-" . $yr,
    "03" => "Mar-" . $yr,
    "04" => "Apr-" . $yr,
    "05" => "May-" . $yr,
    "06" => "Jun-" . $yr,
    "07" => "Jul-" . $yr,
    "08" => "Aug-" . $yr,
    "09" => "Sept-" . $yr,
    "10" => "Oct-" . $yr,
    "11" => "Nov-" . $yr,
    "12" => "Dec-" . $yr
);
?>

<style>
.pm-report-wrapper {
    width: 100%;
    margin: 0;
    padding: 0;
}

.pm-header-section {
    background: linear-gradient(135deg, #1e5a96 0%, #2c7fb8 100%);
    padding: 30px;
    color: white;
    display: flex;
    align-items: center;
    gap: 20px;
}

.pm-header-section img {
    max-width: 120px;
    height: auto;
    flex-shrink: 0;
}

.pm-header-text h4 {
    font-size: 16px;
    font-weight: 700;
    line-height: 1.4;
    margin: 0;
}

.pm-title-section {
    background: #1e5a96;
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    width: 100%;
}

.pm-scroll-container {
    width: 100%;
    overflow-x: scroll;
    overflow-y: visible;
    display: block;
}

.pm-scroll-container::-webkit-scrollbar {
    height: 12px;
}

.pm-scroll-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.pm-scroll-container::-webkit-scrollbar-thumb {
    background: #1e5a96;
    border-radius: 6px;
}

.pm-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #2c7fb8;
}

.pm-yearly-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    table-layout: auto;
}

.pm-yearly-table thead {
    background: linear-gradient(135deg, #1e5a96 0%, #2c7fb8 100%);
    color: white;
    position: sticky;
    top: 0;
    z-index: 10;
}

.pm-yearly-table th {
    padding: 10px 5px;
    text-align: center;
    font-weight: 600;
    font-size: 10px;
    border: 1px solid #0d3a5c;
    height: auto;
    word-break: break-word;
}

.pm-yearly-table td {
    padding: 8px 5px;
    text-align: center;
    border: 1px solid #d0d0d0;
    font-size: 10px;
    height: auto;
}

.pm-yearly-table tbody tr {
    transition: background-color 0.2s ease;
}

.pm-yearly-table tbody tr:nth-child(4n+1),
.pm-yearly-table tbody tr:nth-child(4n+2) {
    background-color: #f8f9fa;
}

.pm-yearly-table tbody tr:hover {
    background-color: #e8f1f7;
}

.pm-sno {
    width: 50px;
    min-width: 50px !important;
    font-weight: 700;
    color: #1e5a96;
}

.pm-machine {
    width: 220px;
    min-width: 220px !important;
    text-align: left;
    font-weight: 500;
    color: #2c3e50;
}

.pm-label {
    background: #f0f3f7;
    font-weight: 600;
    color: #1e5a96;
    width: 100px;
    min-width: 100px !important;
}

.pm-month-header {
    background: #1e5a96;
    color: white;
    font-weight: 700;
}

.pm-week-header {
    background: #e8f1f7;
    color: #1e5a96;
    font-weight: 600;
    font-size: 9px;
}

.pm-plan-cell {
    position: relative;
    cursor: pointer;
}

.pm-plan-icon {
    width: 18px;
    height: 18px;
    opacity: 0.8;
    transition: all 0.2s ease;
}

.pm-plan-icon:hover {
    opacity: 1;
    transform: scale(1.2);
}

.pm-tooltip {
    position: relative;
    display: inline-block;
}

.pm-tooltip .pm-tooltiptext {
    visibility: hidden;
    background-color: #2c3e50;
    color: white;
    text-align: center;
    border-radius: 4px;
    padding: 5px 8px;
    position: absolute;
    z-index: 100;
    bottom: 120%;
    left: 50%;
    margin-left: -35px;
    white-space: nowrap;
    font-size: 9px;
    opacity: 0;
    transition: opacity 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.pm-tooltip .pm-tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -4px;
    border-width: 4px;
    border-style: solid;
    border-color: #2c3e50 transparent transparent transparent;
}

.pm-tooltip:hover .pm-tooltiptext {
    visibility: visible;
    opacity: 1;
}

.pm-done-date {
    background-color: #d4edda;
    color: #155724;
    font-weight: 600;
    padding: 3px 6px;
    border-radius: 3px;
    font-size: 9px;
}

.pm-empty {
    color: #bdc3c7;
}

.pm-footer {
    background: #f8f9fa;
    padding: 12px;
    text-align: center;
    font-size: 9px;
    color: #7f8c8d;
    border-top: 1px solid #e0e6ed;
}

@media print {
    .pm-scroll-container {
        overflow: visible !important;
    }

    .pm-yearly-table {
        width: 100% !important;
    }

    @page {
        size: A3 landscape;
        margin: 10mm;
    }
}
</style>

<div class="pm-report-wrapper">
    <div class="pm-header-section">
        <img src="../public/images/logo.jpg" alt="Logo">
        <div class="pm-header-text">

            <h4>L&T Construction<br> POWER TRANSMISSION & DISTRIBUTION <br> TLT-PONDICHERRY,PITHAMPUR & KANCHIPURAM
                UNITS<br>QUALITY,ENVIRONMENT,HEALTH & SAFETY MANAGEMENT SYSTEM</h4>

        </div>
    </div>

    <div class="pm-title-section">
        PREVENTIVE MAINTENANCE SCHEDULE - <?php echo $year; ?>
    </div>

    <div class="pm-scroll-container">
        <table class="pm-yearly-table" border="1" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th rowspan="3" class="pm-sno" style="color:white;">SNO</th>
                    <th rowspan="3" class="pm-machine" style="color:white;">Machine Number & Code</th>
                    <th rowspan="2" class="pm-month-header"><?php echo $year; ?></th>
                    <?php foreach ($month1 as $key => $value) { ?>
                    <th colspan="<?php    echo isset($weeks[$key]) ? $weeks[$key] : 4; ?>" class="pm-month-header">
                        <?php    echo $value; ?>
                    </th>
                    <?php } ?>
                </tr>
                <tr>
                    <?php foreach ($month1 as $key => $value) { ?>
                    <th colspan="<?php    echo isset($weeks[$key]) ? $weeks[$key] : 4; ?>" class="pm-month-header">
                        Planned
                        Week</th>
                    <?php } ?>
                </tr>
                <tr>
                    <th class="pm-week-header">Weeks</th>
                    <?php 
                    foreach ($month1 as $key => $value) {
    $no_of_weeks = isset($weeks[$key]) ? $weeks[$key] : 4;
    for ($i = 1; $i <= $no_of_weeks; $i++) {
        echo "<th class='pm-week-header'>W" . $i . "</th>";
    }
} 
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sno = 1;
if (isset($machine_details) && count($machine_details) > 0) {
    foreach ($machine_details as $machine) {
        $machine_id = isset($machine->machine_id) ? $machine->machine_id : null;
        if (!$machine_id)
            continue;
                ?>
                <tr>
                    <td rowspan="2" class="pm-sno"><?php        echo $sno; ?></td>
                    <td rowspan="2" class="pm-machine">
                        <strong><?php        echo isset($machine->asset_code) ? $machine->asset_code : ''; ?></strong><br>
                        <small><?php        echo isset($machine->machine_name) ? $machine->machine_name : ''; ?></small>
                    </td>
                    <td class="pm-label">Plan</td>
                    <?php  
                    foreach ($month1 as $key => $value) {
            $no_of_weeks = isset($weeks[$key]) ? $weeks[$key] : 4;
            for ($i = 1; $i <= $no_of_weeks; $i++) {
                if (isset($data[$machine_id][$key][$i]) && !empty($data[$machine_id][$key][$i]['date'])) {
                    echo "<td class='pm-plan-cell'>";
                    echo "<span class='pm-tooltip'>";
                    echo "<img src='../public/images/plan.png' alt='Plan' class='pm-plan-icon'>";
                    echo "<span class='pm-tooltiptext'>" . $data[$machine_id][$key][$i]['date'] . "</span>";
                    echo "</span>";
                    echo "</td>";
                } else {
                    echo "<td class='pm-empty'>—</td>";
                }
            }
        }
                    ?>
                </tr>
                <tr>
                    <td class="pm-label">Actual Done</td>
                    <?php  
                    foreach ($month1 as $key => $value) {
            $no_of_weeks = isset($weeks[$key]) ? $weeks[$key] : 4;
            for ($i = 1; $i <= $no_of_weeks; $i++) {
                if (isset($data[$machine_id][$key][$i]) && !empty($data[$machine_id][$key][$i]['done_date'])) {
                    echo "<td><span class='pm-done-date'>" . $data[$machine_id][$key][$i]['done_date'] . "</span></td>";
                } else {
                    echo "<td class='pm-empty'>—</td>";
                }
            }
        }
                    ?>
                </tr>
                <?php
        $sno++;
    }
} else {
    echo "<tr><td colspan='50' style='text-align: center; padding: 30px;'>No data available</td></tr>";
}
                ?>
            </tbody>
        </table>
    </div>

    <div class="pm-footer">
        Copyright © 2025 - IFIVE Techsol Pvt Ltd
    </div>
</div>