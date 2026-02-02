<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.report-container {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    margin-bottom: 20px;
}

.report-header {
    background: linear-gradient(135deg, #024d87 0%, #024d87 100%);
    padding: 30px;
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
    font-weight: 900;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
    color: white;
}

.report-header p {
    font-size: 15px;
    opacity: 0.95;
    margin-bottom: 4px;
    color: white;
    font-weight: 700;
}

.machine-header {
    background: linear-gradient(135deg, #024d87 0%, #024d87 100%);
    color: white;
    padding: 16px;
    font-weight: 900;
    font-size: 14px;
    text-align: left;
}

.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    font-size: 12px;
}

table thead {
    background: linear-gradient(135deg, #024d87 0%, #024d87 100%);
    color: white;
    position: sticky;
    top: 0;
    z-index: 10;
}

table th {
    padding: 14px 10px;
    text-align: center;
    font-weight: 900;
    height: auto;
    border: 1px solid #667eea;
    font-size: 13px;
    text-transform: uppercase;
    color: white;
}

table td {
    padding: 12px 10px;
    text-align: left;
    border: 1px solid #e0e6ed;
    height: auto;
    vertical-align: middle;
    font-size: 13px;
    font-weight: 600;
}

table tbody tr {
    transition: background-color 0.2s ease;
    height: auto;
}

table tbody tr:hover {
    background-color: #f8f9ff;
}

table tbody tr:nth-child(odd) {
    background-color: #fafbfc;
}

.sno-cell {
    text-align: center;
    font-weight: 900;
    color: #667eea;
    width: 45px;
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    font-size: 13px;
}

.slip-cell {
    font-weight: 900;
    color: #2c3e50;
    text-align: center;
    font-size: 13px;
}

.date-cell {
    font-family: 'Courier New', monospace;
    color: #2c3e50;
    text-align: center;
    font-weight: 700;
    font-size: 13px;
}

.shift-cell {
    text-align: center;
    font-weight: 900;
    color: #024d87;
    font-size: 13px;
}

.action-cell {
    color: #2c3e50;
    font-weight: 700;
    font-size: 13px;
}

.time-cell {
    background: #e3f2fd;
    color: #1976d2;
    font-weight: 900;
    text-align: center;
    font-family: 'Courier New', monospace;
    font-size: 13px;
}

.remarks-cell {
    color: #2c3e50;
    font-size: 13px;
    font-weight: 700;
}

.causes-cell {
    color: #2c3e50;
    font-size: 13px;
    font-weight: 700;
}

.footer-note {
    padding: 20px;
    text-align: center;
    font-size: 11px;
    color: #7f8c8d;
    border-top: 1px solid #e0e6ed;
    background: #f8f9fa;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #7f8c8d;
}

.pagebreak {
    page-break-after: always;
    clear: both;
}

.hide {
    display: none;
}

.print {
    display: none;
}

.views {
    display: block;
}

@media print {
    html {
        background: white;
    }

    body {
        margin: 0;
    }

    .report-container {
        box-shadow: none;
        border: 1px solid #ddd;
        margin-bottom: 0;
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

    .machine-header {
        background: #333 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .time-cell,
    .sno-cell {
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
        padding: 6px;
        border: 0.5px solid #000;
    }

    tr {
        page-break-inside: avoid;
    }

    .pagebreak {
        clear: both;
        page-break-after: always;
    }

    .hide {
        display: block;
    }

    .print {
        display: block;
    }

    .views {
        display: none;
    }

    .footer-note {
        display: none;
    }
}

@media (max-width: 768px) {
    .report-header {
        padding: 20px;
    }

    .report-header h3 {
        font-size: 18px;
    }

    table {
        font-size: 10px;
    }

    table th,
    table td {
        padding: 8px;
    }

    table th {
        font-size: 9px;
    }
}
</style>

<!-- View Mode - Single Table -->
<?php 
$loop = 0;
$allMachines = isset($machine_name) ? $machine_name : [];
$allData = isset($data) ? $data : [];

if (count($allMachines) > 0) {
    $firstTable = true;
    foreach ($allMachines as $mk => $mv) {
        $data1 = collect($allData)->where('machine_id', $mv->machine_id);

        if (count($data1) > 0) {
            if ($firstTable) {
                $firstTable = false;
?>

<div class="report-container views">
    <div class="report-header">
        <img src="{{asset('images/logo.jpg')}}" alt='Company Logo'>
        <h3>History Card</h3>
        <p><strong style="color: white;">For the Period From {{$start_date}} To {{$end_date}}</strong></p>
    </div>

    <div class="table-wrapper">
        <table border="1" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 45px;">S.No</th>
                    <th style="width: 90px;">Slip No</th>
                    <th style="width: 90px;">Date</th>
                    <th style="width: 60px;">Shift</th>
                    <th style="width: 150px;">Action Taken</th>
                    <th style="width: 100px;">Time Taken<br>(HH:MM)</th>
                    <th style="width: 120px;">Availability<br>in P/M</th>
                    <th style="width: 120px;">Frequency<br>in Month</th>
                    <th style="width: 130px;">Remarks</th>
                    <th style="width: 130px;">Causes</th>
                </tr>
            </thead>
            <tbody>

                <?php 
      }
?>

                <tr>
                    <td colspan="10" class="machine-header">
                        🏭 Machine Name: <strong style="color: white;">{{$mv->machine_name}}</strong>
                    </td>
                </tr>

                <?php 
      $i = 1;
            foreach ($data1 as $key => $value) {
?>

                <tr>
                    <td class="sno-cell">{{$i}}</td>
                    <td class="slip-cell">{{$value->ticket_number}}</td>
                    <td class="date-cell">{{$value->issue_date}}</td>
                    <td class="shift-cell">{{$value->shift}}</td>
                    <td class="action-cell">{{$value->corrective_action}}</td>
                    <td class="time-cell">{{$value->time_diff}}</td>
                    <td></td>
                    <td></td>
                    <td class="remarks-cell">{{$value->remarks}}</td>
                    <td class="causes-cell">{{$value->causes}}</td>
                </tr>

                <?php 
        $i++;
            }
        }
    }
?>

            </tbody>
        </table>
    </div>

    <div class="footer-note">
        <p><strong>History Card Report</strong> | Complete breakdown history for all machines | Generated on <span
                id="footerDate"></span></p>
    </div>
</div>

<?php 
} else {
?>

<div class="report-container views">
    <div class="empty-state">
        <p>No history data available for the selected period</p>
    </div>
</div>

<?php 
}
?>

<!-- Print Mode - Separate Tables per Machine -->
<?php 
$loop = 0;
$allMachines = isset($machine_name) ? $machine_name : [];
$allData = isset($data) ? $data : [];

if (count($allMachines) > 0) {
    foreach ($allMachines as $mk => $mv) {
        $data1 = collect($allData)->where('machine_id', $mv->machine_id);

        if (count($data1) > 0) {
            if ($loop > 0) {
                echo '<div class="pagebreak"></div>';
            }
?>

<div class="report-container print">
    <div class="report-header">
        <img src="{{asset('images/logo.jpg')}}" alt='Company Logo'>
        <h3>History Card</h3>
        <p><strong style="color: white;">For the Period From {{$start_date}} To {{$end_date}}</strong></p>
        <p style="margin-top: 10px; color: white;"><strong style="color: white;">Machine: {{$mv->machine_name}}</strong>
        </p>
    </div>

    <div class="table-wrapper">
        <table border="1" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 45px;">S.No</th>
                    <th style="width: 90px;">Slip No</th>
                    <th style="width: 90px;">Date</th>
                    <th style="width: 60px;">Shift</th>
                    <th style="width: 150px;">Action Taken</th>
                    <th style="width: 100px;">Time Taken<br>(HH:MM)</th>
                    <th style="width: 120px;">Availability<br>in P/M</th>
                    <th style="width: 120px;">Frequency<br>in Month</th>
                    <th style="width: 130px;">Remarks</th>
                    <th style="width: 130px;">Causes</th>
                </tr>
            </thead>
            <tbody>

                <?php 
      $i = 1;
            foreach ($data1 as $key => $value) {
?>

                <tr>
                    <td class="sno-cell">{{$i}}</td>
                    <td class="slip-cell">{{$value->ticket_number}}</td>
                    <td class="date-cell">{{$value->issue_date}}</td>
                    <td class="shift-cell">{{$value->shift}}</td>
                    <td class="action-cell">{{$value->corrective_action}}</td>
                    <td class="time-cell">{{$value->time_diff}}</td>
                    <td></td>
                    <td></td>
                    <td class="remarks-cell">{{$value->remarks}}</td>
                    <td class="causes-cell">{{$value->causes}}</td>
                </tr>

                <?php 
        $i++;
            }
?>

            </tbody>
        </table>
    </div>

    <div class="footer-note">
        <p><strong>History Card Report</strong> | Machine: {{$mv->machine_name}} | Generated on <span
                id="footerDate"></span></p>
    </div>
</div>

<?php 
      $loop++;
        }
    }
}
?>

<script>
// Set current date
var today = new Date();
var dateStr = (today.getMonth() + 1) + "/" + today.getDate() + "/" + today.getFullYear();
var elements = document.querySelectorAll('#footerDate');
elements.forEach(function(el) {
    el.innerHTML = today.toLocaleString();
});
</script>