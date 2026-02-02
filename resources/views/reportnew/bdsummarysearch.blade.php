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

table tbody {
    display: table-row-group;
}

table tbody tr {
    display: table-row;
}

table tbody td {
    padding: 25px;
    text-align: left;
    border: 2px solid #e0e6ed;
    vertical-align: top;
    background: linear-gradient(135deg, #f8f9fa 0%, #fafbfc 100%);
    transition: all 0.3s ease;
}

table tbody tr:hover td {
    background: linear-gradient(135deg, #f0f3f7 0%, #e8ecf2 100%);
    box-shadow: inset 0 0 10px rgba(102, 126, 234, 0.08);
}

table tbody td:nth-child(1) {
    width: 33.333%;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-right: 3px solid #024d87;
}

table tbody td:nth-child(2) {
    width: 33.333%;
    background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
    border-right: 3px solid #024d87;
}

table tbody td:nth-child(3) {
    width: 33.334%;
    background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
}

.stat-label {
    font-weight: 900;
    color: #1a1a1a;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.stat-icon {
    font-size: 24px;
}

.stat-value {
    font-size: 32px;
    font-weight: 900;
    color: #024d87;
    margin-bottom: 16px;
}

table tbody td:nth-child(2) .stat-value {
    color: #024d87;
}

table tbody td:nth-child(3) .stat-value {
    color: #ff9800;
}

.stat-description {
    font-size: 13px;
    color: #2c3e50;
    line-height: 1.6;
    margin-top: 8px;
    font-weight: 600;
}

.stat-item {
    margin-bottom: 18px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.stat-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.status-badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    margin-top: 8px;
}

.badge-positive {
    background: #d4edda;
    color: #155724;
}

.badge-negative {
    background: #f8d7da;
    color: #721c24;
}

.badge-pending {
    background: #fff3cd;
    color: #856404;
}

.footer-note {
    padding: 25px;
    text-align: center;
    font-size: 12px;
    color: #7f8c8d;
    border-top: 2px solid #e0e6ed;
    background: #f8f9fa;
}

.summary-stats {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e0e6ed;
}

.summary-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.summary-label {
    font-size: 13px;
    color: #2c3e50;
    font-weight: 700;
}

.summary-value {
    font-size: 20px;
    font-weight: 900;
    color: #024d87;
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

    table tbody td {
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
        padding: 15px;
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

    table tbody td {
        padding: 15px;
    }

    .stat-value {
        font-size: 20px;
    }

    .stat-label {
        font-size: 12px;
    }

    .summary-stats {
        gap: 15px;
    }
}
</style>

<div class="report-container">
    <div class="report-header">
        <img src="{{asset('images/logo.jpg')}}" alt='Company Logo'>
        <h3>Breakdown Summary Report</h3>

        <p>For the Period From <strong style="color:white;">{{$start_date}}</strong> To <strong
                style="color:white;">{{$end_date}}</strong></p>
    </div>

    <div class="table-wrapper">
        <table border="1" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <!-- Column 1: Call Status -->
                    <td>
                        <div class="stat-item">
                            <div class="stat-label">
                                <span class="stat-icon">📞</span>
                                Call Raised
                            </div>
                            <div class="stat-value">{{isset($data[0]->call_raised) ? $data[0]->call_raised : 0}}</div>
                            <span class="status-badge badge-positive">Active</span>
                            <div class="stat-description">Total calls raised during the period</div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-label">
                                <span class="stat-icon">❌</span>
                                Cancelled
                            </div>
                            <div class="stat-value">{{isset($data[0]->cancelled) ? $data[0]->cancelled : 0}}</div>
                            <span class="status-badge badge-negative">Cancelled</span>
                            <div class="stat-description">Total cancelled breakdowns</div>
                        </div>
                    </td>

                    <!-- Column 2: Resolution Status -->
                    <td>
                        <div class="stat-item">
                            <div class="stat-label">
                                <span class="stat-icon">✅</span>
                                Resolved by PMD
                            </div>
                            <div class="stat-value">{{isset($data[0]->resolved) ? $data[0]->resolved : 0}}</div>
                            <span class="status-badge badge-positive">Completed</span>
                            <div class="stat-description">Successfully resolved by PMD team</div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-label">
                                <span class="stat-icon">⏳</span>
                                Pending to Resolve
                            </div>
                            <div class="stat-value">{{isset($data[0]->pending_resolve) ? $data[0]->pending_resolve : 0}}
                            </div>
                            <span class="status-badge badge-pending">Pending</span>
                            <div class="stat-description">Awaiting resolution by PMD</div>
                        </div>
                    </td>

                    <!-- Column 3: Acknowledgment & Downtime -->
                    <td>
                        <div class="stat-item">
                            <div class="stat-label">
                                <span class="stat-icon">⏱️</span>
                                Pending to Acknowledge
                            </div>
                            <div class="stat-value">{{isset($data[0]->pending_ackn) ? $data[0]->pending_ackn : 0}}</div>
                            <span class="status-badge badge-pending">Awaiting</span>
                            <div class="stat-description">Awaiting acknowledgment from user</div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-label">
                                <span class="stat-icon">⚙️</span>
                                Total Downtime
                            </div>
                            <div class="stat-value">
                                {{isset($data[0]->break_down_hr) ? $data[0]->break_down_hr : '0 Hrs'}}
                            </div>
                            <span class="status-badge badge-negative">Critical</span>
                            <div class="stat-description">Total equipment downtime in hours</div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="footer-note">
            <strong>Report Summary:</strong>
            <div class="summary-stats">
                <div class="summary-item">
                    <span class="summary-label">Total Calls Raised:</span>
                    <span class="summary-value">{{isset($data[0]->call_raised) ? $data[0]->call_raised : 0}}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Resolved Cases:</span>
                    <span class="summary-value">{{isset($data[0]->resolved) ? $data[0]->resolved : 0}}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Pending Cases:</span>
                    <span
                        class="summary-value">{{isset($data[0]->pending_resolve) ? $data[0]->pending_resolve : 0}}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Cancelled:</span>
                    <span class="summary-value">{{isset($data[0]->cancelled) ? $data[0]->cancelled : 0}}</span>
                </div>
            </div>
            <p style="margin-top: 15px; font-size: 11px; color: #999;">
                Report generated on <span id="footerDate"></span> | Summary of all breakdown activities during the
                reporting
                period | A4 format recommended
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