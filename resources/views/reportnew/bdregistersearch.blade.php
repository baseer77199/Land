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
    font-size: 22px;
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
    font-size: 11px;
}

table thead {
    background: linear-gradient(135deg, #024d87 0%, #024d87 100%);
    color: white;
    position: sticky;
    top: 0;
    z-index: 10;
}

table th {
    padding: 12px 8px;
    text-align: center;
    font-weight: 600;
    font-size: 10px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    border: 1px solid #024d87;
    line-height: 1.4;
}

table td {
    padding: 10px 8px;
    text-align: left;
    border: 1px solid #e0e6ed;
    font-size: 10px;
    word-wrap: break-word;
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

.sno-cell {
    text-align: center;
    font-weight: 700;
    color: #024d87;
    width: 50px;
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
}

.ticket-cell {
    font-weight: 600;
    color: #2c3e50;
    min-width: 120px;
}

.machine-cell {
    font-weight: 600;
    color: #2c3e50;
    min-width: 120px;
}

.category-cell {
    background: #e8f4f8;
    color: #0c5460;
    font-weight: 600;
}

.details-cell {
    color: #555;
    max-width: 200px;
}

.action-cell {
    color: #555;
}

.time-cell {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    background: #e3f2fd;
    color: #1976d2;
}

.status-cell {
    text-align: center;
    font-weight: 600;
}

.status-complete {
    background: #d4edda;
    color: #155724;
    padding: 4px 8px;
    border-radius: 3px;
    display: inline-block;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
    padding: 4px 8px;
    border-radius: 3px;
    display: inline-block;
}

.status-inprogress {
    background: #cce5ff;
    color: #004085;
    padding: 4px 8px;
    border-radius: 3px;
    display: inline-block;
}

.footer-note {
    padding: 20px;
    text-align: center;
    font-size: 11px;
    color: #7f8c8d;
    border-top: 1px solid #e0e6ed;
    background: #f8f9fa;
}

.summary-stats {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #e0e6ed;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 600;
}

.stat-badge {
    background: #024d87;
    color: white;
    padding: 2px 8px;
    border-radius: 3px;
    min-width: 40px;
    text-align: center;
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

    .status-complete,
    .status-pending,
    .status-inprogress,
    .category-cell,
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
        font-size: 8px;
        page-break-inside: avoid;
    }

    table th,
    table td {
        padding: 3px;
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
        font-size: 9px;
    }

    table th,
    table td {
        padding: 6px 4px;
    }

    table th {
        font-size: 8px;
    }
}
</style>

<div class="report-container">
    <div class="report-header">
        <div class="report-header-content">
            <img src="{{asset('images/logo.jpg')}}" alt='Company Logo'>
            <div class="report-title">
                <h3>Breakdown Report Register</h3>

                <p>For the Period From <strong style="color: white;">{{$start_date}}</strong> To <strong
                        style="color: white;">{{$end_date}}</strong></p>
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
                    <th style="width: 40px;">S.No</th>
                    <th style="width: 100px;">Ticket No<br>Date - Shift</th>
                    <th style="width: 130px;">Machine Name</th>
                    <th style="width: 100px;">Category/<br>BD Type</th>
                    <th style="width: 150px;">Breakdown Details</th>
                    <th style="width: 130px;">BD Raised On<br>Department<br>Raised By</th>
                    <th style="width: 130px;">Action Taken</th>
                    <th style="width: 110px;">Attended By PMD<br>(PS No)<br>Time Taken (HH:MM)</th>
                    <th style="width: 120px;">BD Completion<br>Acknowledged On<br>Action By</th>
                    <th style="width: 80px;">Completion<br>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
        $i = 1;
$completed = 0;
$pending = 0;
$inprogress = 0;

if (isset($data) && count($data) > 0) {
    foreach ($data as $key => $value) {
        // Determine status for counting
        $status = strtolower(trim($value->com_status));
        if (strpos($status, 'complete') !== false || strpos($status, 'done') !== false) {
            $completed++;
            $statusClass = 'status-complete';
            $statusText = '✓ Complete';
        } elseif (strpos($status, 'pending') !== false) {
            $pending++;
            $statusClass = 'status-pending';
            $statusText = '⏳ Pending';
        } else {
            $inprogress++;
            $statusClass = 'status-inprogress';
            $statusText = '⟳ In Progress';
        }
            ?>
                <tr>
                    <td class="sno-cell">{{$i}}</td>
                    <td class="ticket-cell">{{$value->slip_no}}</td>
                    <td class="machine-cell">{{$value->machine}}</td>
                    <td class="category-cell">{{$value->br_type}}</td>
                    <td class="details-cell">{{$value->bd_detail}}</td>
                    <td class="action-cell">{{$value->bd_raised}}</td>
                    <td class="action-cell">{{$value->corrective_action}}</td>
                    <td class="time-cell">{{$value->action_by}}</td>
                    <td class="action-cell">{{$value->complete}}</td>
                    <td class="status-cell">
                        <span class="{{$statusClass}}">{{$statusText}}</span>
                    </td>
                </tr>
                <?php
        $i++;
    }
} else {
    echo "<tr><td colspan='10' style='text-align: center; padding: 40px; color: #999;'>No breakdown incidents recorded for the selected period</td></tr>";
}
        ?>
            </tbody>
        </table>

        <div class="footer-note">
            <strong>Report Summary & Information:</strong>
            <div class="summary-stats">
                <div class="stat-item">
                    <span style="color: #155724;">✓ Completed:</span>
                    <span class="stat-badge">{{isset($completed) ? $completed : 0}}</span>
                </div>
                <div class="stat-item">
                    <span style="color: #856404;">⏳ Pending:</span>
                    <span class="stat-badge"
                        style="background: #ffc107; color: #000;">{{isset($pending) ? $pending : 0}}</span>
                </div>
                <div class="stat-item">
                    <span style="color: #004085;">⟳ In Progress:</span>
                    <span class="stat-badge"
                        style="background: #17a2b8;">{{isset($inprogress) ? $inprogress : 0}}</span>
                </div>
                <div class="stat-item">
                    <span style="color: #024d87;">📊 Total:</span>
                    <span class="stat-badge">{{isset($i) ? $i - 1 : 0}}</span>
                </div>
            </div>
            <p style="margin-top: 10px; font-size: 10px; color: #999;">
                Report generated on <span id="footerDate"></span> | A3 Landscape format recommended | Time format:
                24-hour
                (HH:MM)
            </p>
        </div>
    </div>
</div>