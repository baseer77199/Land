<?php
error_reporting(0);
//dd($urlmenu);

$allowed_host = array('172.31.61.248:156', '192.168.1.5', 'localhost', 'localhost:156', '172.31.61.248', '103.74.215.40', 'ticketingsolutions.lntecc.com', 'ticketingsolutions.lntecc.com:156');

header_remove('Access-Control-Allow-Methods');
header_remove('Access-Control-Allow-Origin');
header_remove('Access-Control-Allow-Headers');
header_remove('Access-Control-Allow-Credentials');



//print_r($allowed_host);die;
if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_host)) {
  header($_SERVER['SERVER_PROTOCOL'] . ' 421 Misdirected Request');

  echo "<html><head>
<title>421 Misdirected Request</title>
</head><body>
<h1>Misdirected Request</h1>
<p>The client needs a new connection for this
request as the requested host name does not match
the Server Name Indication (SNI) in use for this
connection.</p>
</body></html>";

  exit;
}



header("content_security_policy: script-src 'self' 'unsafe-eval'; object-src 'self'");
if (isset($_GET['ref_id'])) {
  $ref_id = $_GET['ref_id'];
  \DB::table('notifications_t')
  ->where('notification_id', $ref_id)
  ->update(['read/unread' => 'read']);
}
date_default_timezone_set('Asia/Calcutta');
$end_time = date('Y-m-d H:i:s', strtotime("+1 minutes"));
$start_time = date('Y-m-d H:i:s');
\Session::put('session_time', $end_time);

if (\Session::get('id')) {
} else {
  $actual_link = URL::to('logout');

  echo '  <script>

            location.replace("' . $actual_link . '")

      </script>';
} ?>

<html>

<head>

    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>L&T</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ERP" />
    <meta name="description" content="ERP-APPLICATIONS">
    <meta name="author" content="I-FIVE">

    <!--script  src="{{ asset('css/bootstrap.min.js') }}"></script-->
    <script src="{{ asset('css/jquery.min.js') }}"></script>

    <link rel="shortcut icon" type="image/x-icon" sizes="16x16" href="{{ asset('images/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('js/bs-iconpicker/css/bootstrap-iconpicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/professional-mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ui.jqgrid.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard/newone.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ui.fancytree.min.css') }}">

    <script src="{{ asset('js/js/jquery.richtext.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/css/richtextmin/richtext.min.css') }}">
    <!---------------------- Date Picker ------------------------->

    <!----------------------- customize css ---------------------->
    <link rel="stylesheet" href="{{ asset('css/customize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweet-alert.css') }}">
    <!-- ------------------------ Dashboard 1 -------------------- -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/dashboard_2.css') }}">

    <!-- <link rel="stylesheet" href="{{ asset('css/sidebar.css')}}"> -->
    <link rel="stylesheet" href="{{ asset('css/professional-navbar.css')}}">

    <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>
    <!--<script src="{{ asset('js/flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2')}}"></script>-->
    <script src="{{ asset('js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('js/bs-iconpicker/js/bootstrap-iconpicker.js') }}"></script>

    <!-- Dashboard  -->

    <script src="{{ asset('js/jquery.countTo.js') }}"></script>


    <!-- bootstrap js -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.jCombo.min.js') }}"></script>

    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <!-- Mega Menu js -->
    <script src="{{ asset('js/jquery.meanmenu.js') }}"></script>




    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/select2.min.js') }}"></script>


    <script src="{{ asset('js/reCopy.js') }}"></script>

    <script src="{{ asset('js/jquery.aCollapTable.js') }}"></script>
    <script src="{{ asset('js/jquery.aCollapTable.min.js') }}"></script>

    <link href="{{ asset('js/bs-iconpicker/css/bootstrap-iconpicker.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-menu-editor.js?v5') }}"></script>


    <!-- <script src="{{ asset('js/bs-iconpicker/js/jquery.fancytree-all.min.js') }}"></script> -->

    <!------------------------ Toggle form ---------------------------->
    <script src="{{ asset('js/ziehharmonika.js') }}"></script>



    <script src="{{ asset('js/fullscreen.js') }}"></script>
    <!-- <script src="{{ asset('js/moment.js') }}"></script> -->
    <script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>

    <!---dashboard widget script--->
    <!-- <script src="{{ asset('js/fullscreen.js') }}"></script> -->



    <script src="{{ asset('js/widget/jquery.newsTicker.js') }}"></script>
    <script src="{{ asset('js/widget/jquery.clock.js') }}"></script>

    <!--jqgrid-->
    <!--<script src="http://www.guriddo.net/demo/css/trirand/ui.jqgrid.css"></script>-->
    <script src="{{ asset('js/ui.multiselect.js')}}"></script>

    <!--11<script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.14.1/plugins/min/ui.multiselect.js"></script>-->

    <!--<script src="http://www.guriddo.net/demo/js/trirand/src/jquery.jqGrid.js"></script>-->
    <!--<script src="{{ asset('js/jquery.jqGrid.js') }}"></script>-->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
        <link rel="stylesheet" href="{{asset('css/font-awesome.css')}} integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/jqgridfont.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/ui.jqgrid.css') }}">
    <script src="{{ asset('js/ui.multiselect.js') }}"></script>
    <link rel="stylesheet" href="{{asset('css/ui.jqgrid.css')}}">


    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.14.1/plugins/min/ui.multiselect.js"></script>-->
    <link rel="stylesheet" href="{{asset('js/ui.multiselect.css')}}">

    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.14.1/plugins/css/ui.multiselect.css">-->
    <script src="{{ asset('js/jszip.min.js') }}"></script>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>-->
    <!--<script src="http://www.guriddo.net/demo/js/trirand/i18n/grid.locale-en.js"></script>-->
    <script src="{{ asset('js/grid.locale-en.js') }}"></script>
    <script src="{{ asset('js/jquery.jqgrid.min.js') }}"></script>





    <link rel="stylesheet" href="{{ asset('css/ui.multiselect.css') }}">
    <script src="{{ asset('js/sweet-alert.min.js') }}"></script>
    <script src="{{ asset('js/sweet-alert.init.js') }}"></script>


    <script src="{{ asset('js/notifIt.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/notifIt.css') }}" type="text/css" rel="stylesheet">



    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">


    <!---------------------------- Line table new -------------------------------->
    <script src="{{ asset('dashboard/kidd.stickytable.min.js') }}"></script>
    <link href="{{ asset('dashboard/kidd.stickytable.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('dashboard/colpick.css') }}" type="text/css" rel="stylesheet">

    <script src="{{ asset('js/custom.js') }}"></script>



    <script src="{{ asset('js/plugins/parsley/src/parsley.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('js/plugins/parsley/src/parsley.css') }}">
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <link href="{{ asset('css/daterangepicker.css') }}" type="text/css" rel="stylesheet">
    <script src="{{ asset('js/highcharts.js') }}"></script>
    <script src="{{ asset('js/exporting.js') }}"></script>
    <script src="{{ asset('js/export-data.js') }}"></script>
    <script src="{{ asset('js/offline-exporting.js') }}"></script>
    <!-- <script src="https://code.highcharts.com/modules/drilldown.js"></script> -->

    <script src="{{ asset('js/jquery.countdownTimer.js') }}"></script>
    <script src="{{ asset('js/bootstrap-session-timeout.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
    <script type="text/javascript">
    var jQuery_1_9_1 = $.noConflict(true);
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        var nt_title = $('#nt-title').newsTicker({
            row_height: 18,
            max_rows: 1,
            duration: 5000,
            pauseOnHover: 0
        });
        $('#digital-clock').clock({
            offset: '+5',
            type: 'digital'
        });

        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var dayNames = ["Sun, ", "Mon, ", "Tue, ", "Wed, ", "Thu, ", "Fri, ", "Sat, "]

        var newDate = new Date();
        newDate.setDate(newDate.getDate() + 1);
        $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate
            .getMonth()] + ' ' + newDate.getFullYear());


        var url = 0;
        <?php  if (!empty($pageMethod)) {   ?>

        var url = "{{ URL::to($pageMethod) }}";
        $('a[href="' + url + '"]').removeClass('menu3css');
        <?php  } ?>

        $('a[href="' + url + '"]').addClass('menu3css');
        $('a[href="' + url + '"]').closest('.mega-parent').find('.three-d-box .front').addClass('active1');

    });
    </script>
</head>

<body class="fix-header fix-sidebar card-no-border">



    <!--<div class="modal fade" id="logout_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"data-backdrop="static" data-keyboard="false">-->
    <!--  <div class="modal-dialog " style="width:480px;">-->
    <!--    <div class="modal-content">-->
    <!--      <div class="modal-body">-->
    <!--        <div class="row">-->
    <!--          <div class="col-md-2">-->
    <!--            <i class="fa fa-warning" style="margin-top:1.1em;font-size:3.5em;color:#da4f49"></i>-->
    <!--          </div>-->
    <!--          <div class="col-md-10 session_popup">-->
    <!--            <h4>Your session is about to expire!</h4>-->
    <!--            <p style="font-size: 15px;">You will be logged out in <span id="timer" style="display: inline;font-size: 30px;font-style: bold"><span id="seconds_time"></span>-->
    <!--            <p style="font-size: 15px;">Do you want to stay signed in?</p>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="clearfix"></div>-->
    <!--      <div class="row text-center">-->
    <!--        <a href="javascript:;" onclick="window.location.reload();" class="btn btn-primary sign_in" aria-hidden="true">Yes, Keep me signed in</a>-->
    <!--        <a href="{{URL::to('logout') }}" class="btn btn-danger" aria-hidden="true">No, Sign me out</a>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->

    <div class="modal fade" id="location_confirm_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog " style="width:480px;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <i class="fa fa-warning" style="margin-top:1.1em;font-size:3.5em;color:#da4f49"></i>
                        </div>
                        <div class="col-md-10 session_popup">
                            <h4>Are you want to change location ?</h4>
                            <!--<p style="font-size: 15px;">You will be logged out in <span id="timer" style="display: inline;font-size: 30px;font-style: bold"><span id="seconds_time"></span>-->
                            <!--<p style="font-size: 15px;">Do you want to stay signed in?</p>-->
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row text-center">
                    <a href="javascript:;" onclick="" class="btn btn-primary sign_in" id="loc-confirm-btn"
                        aria-hidden="true">Yes</a>
                    <a href="" id="btn-cancel-event-loc" class="btn btn-danger" aria-hidden="true">No</a>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------ Header menu start from here -------------------------------------->


    <!-- Modern Top Header -->

    <!-- Modern White Top Header -->
    <header class="modern-topbar">
        <div class="topbar-container">

            <!-- Left Side: Logo & Brand -->
            <div class="topbar-left-section">
                <!-- Mobile Menu Toggle -->
                <!-- <button class="mobile-sidebar-toggle" id="mobileSidebarToggle">
                    <i class="fa fa-bars"></i>
                </button> -->

                <!-- Logo & Brand Name -->
                <a href="{{URL::to('home')}}" class="topbar-logo">
                    <img src="{{ asset('images/l&tlogo.png') }}" alt="Logo" class="topbar-logo-img">
                    <div class="topbar-brand">
                        <!-- <span class="topbar-brand-name">L&T Construction</span> -->
                        <!-- <span class="topbar-brand-subtitle">Power Transmission & Distribution</span> -->
                    </div>
                </a>
            </div>

            <!-- Center: Search Bar -->
            <!-- <div class="topbar-center-section">
                <div class="topbar-search-wrapper">
                    <i class="fa fa-search topbar-search-icon"></i>
                    <input type="text" class="topbar-search-input" placeholder="Search anything...">
                </div>
            </div> -->

            <!-- Right Side: Actions & Profile -->
            <div class="topbar-right-section">

                <!-- Theme Toggle (Sun/Moon) -->
                <div class="theme-toggle-btn">
                    <a href="javascript:void(0)" class="topbar-icon-btn" title="Light Mode">
                        <i class="fa fa-sun-o"></i>
                    </a>
                    <a href="javascript:void(0)" class="topbar-icon-btn" title="Dark Mode">
                        <i class="fa fa-moon-o"></i>
                    </a>
                </div>
                <?php
// Get session data
$user = \Session::get('id');
$comp = \Session::get('companyid');
$loc = \Session::get('location');

// Fetch unread notifications for the user
$count_no = \DB::table('notifications_t')
    ->where('read/unread', 'unread')
    ->where('company_id', $comp)
    ->where('user_id', $user)
    ->select('*')
    ->orderBy('notification_id', 'desc')
    ->get();

$count_noti = count($count_no);
?>

                <!-- Notifications -->
                <div style="position: relative;">
                    <a href="#" class="topbar-icon-btn notification-trigger" onclick="toggleNotifications(event)"
                        title="Notifications">
                        <i class="fa fa-bell"></i>
                        <?php if ($count_noti > 0) { ?>
                        <span class="notification-badge button__badge"><?php echo $count_noti; ?></span>
                        <?php } ?>
                    </a>

                    <!-- Notification Dropdown -->
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <h3>
                                <i class="fa fa-bell" style="color: #3b82f6;"></i>
                                Notifications
                            </h3>
                            <div class="header-actions">
                                <span class="notification-count"><?php echo $count_noti; ?> new</span>
                                <?php if ($count_noti > 0) { ?>
                                <button class="mark-all-read" onclick="markAllAsRead()">
                                    Mark all read
                                </button>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="notification-body">
                            <?php if ($count_noti > 0) {
                foreach ($count_no as $notification) { ?>
                            <div class="notification-item unread"
                                data-notification-id="<?php echo $notification->notification_id; ?>">
                                <div class="notification-content-wrapper">
                                    <!-- Hidden form for POST submission -->
                                    <form id="noti-form-<?php echo $notification->notification_id; ?>"
                                        action="{{ route('notification.mark-read') }}" method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="notification_id"
                                            value="<?php echo $notification->notification_id; ?>">
                                        <input type="hidden" name="reference_source_id"
                                            value="<?php echo $notification->reference_source_id; ?>">
                                        <input type="hidden" name="btn_val"
                                            value="<?php echo $notification->btn_val; ?>">
                                        <input type="hidden" name="reference_url"
                                            value="<?php echo $notification->reference_url; ?>">
                                    </form>

                                    <a href="javascript:void(0)"
                                        onclick="markAsReadAndRedirect(<?php echo $notification->notification_id; ?>, '<?php echo $notification->reference_url; ?>')"
                                        class="notification-link">
                                        <div class="notification-content">
                                            <p class="notification-text">
                                                <?php echo $notification->description; ?>
                                            </p>
                                            <span class="notification-time">
                                                <?php echo \Carbon\Carbon::parse($notification->created_at)->diffForHumans(); ?>
                                            </span>
                                        </div>
                                    </a>
                                    <div class="notification-actions">
                                        <button class="mark-read-btn"
                                            onclick="markAsReadOnly(<?php echo $notification->notification_id; ?>)"
                                            title="Mark as read">
                                            ✓
                                        </button>
                                    </div>
                                    <span class="unread-indicator"></span>
                                </div>
                            </div>
                            <?php }
            } else { ?>
                            <div class="empty-notifications">
                                <div
                                    style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                                    <i class="fa fa-bell-slash-o" style="font-size: 24px; color: #9ca3af;"></i>
                                </div>
                                <p style="margin: 0 0 4px; font-size: 14px; font-weight: 600; color: #374151;">No new
                                    notifications</p>
                                <span style="font-size: 12px; color: #9ca3af;">You're all caught up!</span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <style>
                /* Notification Dropdown Styles */
                .notification-dropdown {
                    position: absolute;
                    top: calc(100% + 10px);
                    right: 0;
                    width: 380px;
                    max-height: 500px;
                    background: #fff;
                    border-radius: 12px;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
                    opacity: 0;
                    visibility: hidden;
                    transform: translateY(-8px);
                    transition: all 0.25s ease;
                    z-index: 1002;
                    overflow: hidden;
                    border: 1px solid #e5e7eb;
                }

                .notification-dropdown.show {
                    opacity: 1;
                    visibility: visible;
                    transform: translateY(0);
                }

                .notification-header {
                    padding: 16px;
                    border-bottom: 1px solid #f3f4f6;
                    background: #fafafa;
                }

                .notification-header h3 {
                    margin: 0 0 8px 0;
                    font-size: 16px;
                    font-weight: 600;
                    color: #1f2937;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }

                .header-actions {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 12px;
                }

                .notification-count {
                    font-size: 13px;
                    color: #6b7280;
                    font-weight: 500;
                }

                .mark-all-read {
                    background: none;
                    border: none;
                    color: #3b82f6;
                    font-size: 13px;
                    font-weight: 600;
                    cursor: pointer;
                    padding: 4px 8px;
                    border-radius: 6px;
                    transition: all 0.2s;
                }

                .mark-all-read:hover {
                    background: #eff6ff;
                }

                .notification-body {
                    max-height: 420px;
                    overflow-y: auto;
                    padding: 8px;
                }

                .notification-item {
                    padding: 12px;
                    border-radius: 8px;
                    margin-bottom: 6px;
                    transition: all 0.2s;
                    background: #fff;
                    border: 1px solid transparent;
                }

                .notification-item.unread {
                    background: #eff6ff;
                    border-color: #dbeafe;
                }

                .notification-item:hover {
                    background: #f9fafb;
                }

                .notification-content-wrapper {
                    display: flex;
                    align-items: flex-start;
                    gap: 8px;
                    position: relative;
                }

                .notification-link {
                    flex: 1;
                    text-decoration: none;
                    color: inherit;
                }

                .notification-content {
                    flex: 1;
                }

                .notification-text {
                    margin: 0 0 6px 0;
                    font-size: 14px;
                    color: #374151;
                    line-height: 1.5;
                }

                .notification-time {
                    font-size: 12px;
                    color: #9ca3af;
                }

                .notification-actions {
                    display: flex;
                    align-items: center;
                    gap: 4px;
                }

                .mark-read-btn {
                    background: #3b82f6;
                    color: white;
                    border: none;
                    width: 28px;
                    height: 28px;
                    border-radius: 6px;
                    cursor: pointer;
                    font-size: 14px;
                    font-weight: bold;
                    transition: all 0.2s;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .mark-read-btn:hover {
                    background: #2563eb;
                    transform: scale(1.05);
                }

                .unread-indicator {
                    position: absolute;
                    top: 50%;
                    left: -8px;
                    transform: translateY(-50%);
                    width: 6px;
                    height: 6px;
                    background: #3b82f6;
                    border-radius: 50%;
                }

                .notification-item:not(.unread) .unread-indicator {
                    display: none;
                }

                .empty-notifications {
                    text-align: center;
                    padding: 40px 20px;
                }

                /* Badge styles */
                .notification-badge {
                    position: absolute;
                    top: -4px;
                    right: -4px;
                    background: #ef4444;
                    color: white;
                    font-size: 10px;
                    font-weight: 700;
                    padding: 2px 6px;
                    border-radius: 10px;
                    min-width: 18px;
                    text-align: center;
                }

                /* Scrollbar styling */
                .notification-body::-webkit-scrollbar {
                    width: 6px;
                }

                .notification-body::-webkit-scrollbar-track {
                    background: #f3f4f6;
                    border-radius: 10px;
                }

                .notification-body::-webkit-scrollbar-thumb {
                    background: #d1d5db;
                    border-radius: 10px;
                }

                .notification-body::-webkit-scrollbar-thumb:hover {
                    background: #9ca3af;
                }
                </style>

                <!-- Profile Section -->
                <div style="position: relative;">
                    <button class="topbar-profile" onclick="toggleProfileMenu(event)">
                        <img src="{{ asset('images/profile_images/' . \Session::get('img')) }}" alt="Profile"
                            class="topbar-profile-img">
                        <div class="topbar-profile-info">
                            <span
                                class="topbar-profile-name">{{ strtoupper(\Session::get('user_name') ?? 'SUPERADMIN') }}</span>
                            <span class="topbar-profile-role">{{ \Session::get('role_name') ?? 'Superadmin' }}</span>
                        </div>
                        <i class="fa fa-chevron-down topbar-profile-arrow"></i>
                    </button>

                    <!-- Profile Dropdown -->
                    <div id="profileDropdown"
                        style="position: absolute; top: 50px; right: 0; min-width: 200px; background: #fff; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.12); opacity: 0; visibility: hidden; transform: translateY(-8px); transition: all 0.25s; z-index: 1002; overflow: hidden; border: 1px solid #e5e7eb;">
                        @php
                        $salt = config('app.key');
                        $userId = \Session::get('id');
                        $hashedId = hash('sha256', $salt . $userId);
                        @endphp

                        <!-- Hidden Form for Profile Edit -->
                        <form id="userprofileedit-form" action="{{URL::to('userprofileedit')}}" method="POST"
                            style="display: none;">
                            {{ csrf_field() }}
                            <input type='hidden' name='id' value="{{ $hashedId }}" id='id' class='id'>
                            <input type='hidden' name='pagemethod' value='myprofile' id='pagemethod' class='pagemethod'>
                        </form>

                        <ul style="margin: 0; padding: 6px; list-style: none;">
                            <li style="border-bottom: 1px solid #f3f4f6; margin-bottom: 4px; padding-bottom: 4px;">
                                <a href="#" onclick="submitProfileForm(event)"
                                    style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; text-decoration: none; color: #374151; font-weight: 500; border-radius: 8px; transition: all 0.2s;">
                                    <span
                                        style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #eff6ff; border-radius: 8px; color: #3b82f6;">
                                        <i class="fa fa-user" style="font-size: 14px;"></i>
                                    </span>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{URL::to('logout')}}"
                                    style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; text-decoration: none; color: #ef4444; font-weight: 600; border-radius: 8px; transition: all 0.2s;">
                                    <span
                                        style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fef2f2; border-radius: 8px; color: #ef4444;">
                                        <i class="fa fa-sign-out" style="font-size: 14px;"></i>
                                    </span>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Section -->
        <div id="sticky-header" class="main-menu-wrapper home2-menu header-sticky">
            <div class="row">
                <div class="">
                    @include('layouts.menu')
                </div>
                <div class="mobile-Menu" style="display: none;">
                    @include('layouts.mobilemenu')
                </div>
            </div>
        </div>
    </header>

    <!-- header end -->
    <!------------------------------ header menu end here ----------------------------->

    <!-- Left sidebar menu start -->
    <div class="m-sidebar">
        <div class="m-sidebar-wrapper">

            <!-- side menu logo start -->
            <div class="m-sidebar-logo">
                <div class="m-sidebar-pin-button" title="Pin/Unpin Menu">
                    <i class="material-icons m-fixed-icon">gps_fixed</i>
                    <i class="material-icons m-not-fixed-icon">gps_not_fixed</i>
                </div>
                <div class="m-sidebar-toggle-button">
                    <i class="material-icons">&#xE317;</i>
                </div>
            </div>
            <!-- side menu logo end -->

            <!-- sidebar menu start -->
            <nav class="m-sidebar-navi">
                <ul>
                    <li class="show">
                        <a href="#" class="m-material-button">
                            <span class="m-icon"><i class="material-icons">&#xE88A;</i></span>
                            <span class="m-label">Dashborad</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="m-material-button">
                            <span class="m-icon"><i class="material-icons">&#xE871;</i></span>
                            <span class="m-label">Layouts</span>
                            <span class="m-arrow-icon"><i class="material-icons">&#xE313;</i></span>
                        </a>
                        <ul>
                            <li>
                                <a href="#" class="m-material-button"><span class="m-label">Boxed Layout</span></a>
                            </li>
                            <li>
                                <a href="#" class="m-material-button"><span class="m-label">Full Layout</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="m-material-button">
                            <span class="m-icon"><i class="material-icons">&#xE89B;</i></span>
                            <span class="m-label">Reports</span>
                        </a>
                    </li>


                </ul>
                <!-- sidebar menu end -->
            </nav>
            <!-- sidebar menu end -->
        </div>
    </div>
    <!-- Left sidebar menu end -->
    <div class="m-overlay"></div>
    <!--Main container start -->
    <main class="m-wrapper">


        <div class="container">

            <div class="bread" style=" display:none;   margin-top: -0.2em; margin-bottom: -0.5em;">
                @include('layouts.breadcrumb')</div>


            @yield('content')

            @extends('layouts.footer')

        </div>
    </main>
    <!--Main container end -->



    <button class="scroll-top tran3s">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </button>

    <script>
    function submitProfileForm(event) {
        event.preventDefault();
        document.getElementById('userprofileedit-form').submit();
    }

    // Mark single notification as read and redirect
    function markAsReadAndRedirect(notificationId, referenceUrl) {
        $.ajax({
            url: "{{ route('notification.mark-read') }}",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                notification_id: notificationId
            },
            success: function(response) {
                if (response.success) {
                    // Remove the notification item from UI
                    $('[data-notification-id="' + notificationId + '"]').fadeOut(300, function() {
                        $(this).remove();
                        updateNotificationBadge();
                        checkIfEmpty();
                    });

                    // Redirect to reference URL if provided
                    if (referenceUrl && referenceUrl !== '' && referenceUrl !== 'null') {
                        setTimeout(function() {
                            window.location.href = referenceUrl;
                        }, 300);
                    }
                }
            },
            error: function(xhr) {
                console.error('Error marking notification as read:', xhr);
                showToast('Error marking notification as read', 'error');
            }
        });
    }

    // Mark as read only (without redirect)
    function markAsReadOnly(notificationId) {
        $.ajax({
            url: "{{ route('notification.mark-read') }}",
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                notification_id: notificationId
            },
            success: function(response) {
                if (response.success) {
                    // Remove the notification item from UI
                    $('[data-notification-id="' + notificationId + '"]').fadeOut(300, function() {
                        $(this).remove();
                        updateNotificationBadge();
                        checkIfEmpty();
                    });

                    showToast('Notification marked as read', 'success');
                }
            },
            error: function(xhr) {
                console.error('Error marking notification as read:', xhr);
                showToast('Error marking notification as read', 'error');
            }
        });
    }

    // Mark all notifications as read
    function markAllAsRead() {
        if (confirm('Mark all notifications as read?')) {
            $.ajax({
                url: "{{ route('notification.mark-all-read') }}",
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Clear all notifications from UI
                        $('.notification-item').fadeOut(300, function() {
                            $(this).remove();
                        });

                        // Hide mark all button
                        $('.mark-all-read').fadeOut(300);

                        // Update badge
                        updateNotificationBadge();

                        // Show no notifications message
                        setTimeout(function() {
                            $('.notification-body').html(`
                            <div class="empty-notifications">
                                <div style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                                    <i class="fa fa-bell-slash-o" style="font-size: 24px; color: #9ca3af;"></i>
                                </div>
                                <p style="margin: 0 0 4px; font-size: 14px; font-weight: 600; color: #374151;">No new notifications</p>
                                <span style="font-size: 12px; color: #9ca3af;">You're all caught up!</span>
                            </div>
                        `);
                            $('.notification-count').text('0 new');
                        }, 300);

                        showToast('All notifications marked as read', 'success');
                    }
                },
                error: function(xhr) {
                    console.error('Error marking all notifications as read:', xhr);
                    showToast('Error marking all notifications as read', 'error');
                }
            });
        }
    }

    // Update notification badge count
    function updateNotificationBadge() {
        $.ajax({
            url: "{{ route('notification.count') }}",
            type: 'GET',
            success: function(response) {
                if (response.count > 0) {
                    $('.button__badge').text(response.count).show();
                    $('.notification-count').text(response.count + ' new');
                } else {
                    $('.button__badge').hide();
                    $('.notification-count').text('0 new');
                    $('.mark-all-read').hide();
                }
            }
        });
    }

    // Check if notification body is empty
    function checkIfEmpty() {
        const itemCount = $('.notification-item').length;
        if (itemCount === 0) {
            setTimeout(function() {
                $('.notification-body').html(`
                <div class="empty-notifications">
                    <div style="width: 60px; height: 60px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                        <i class="fa fa-bell-slash-o" style="font-size: 24px; color: #9ca3af;"></i>
                    </div>
                    <p style="margin: 0 0 4px; font-size: 14px; font-weight: 600; color: #374151;">No new notifications</p>
                    <span style="font-size: 12px; color: #9ca3af;">You're all caught up!</span>
                </div>
            `);
                $('.mark-all-read').fadeOut(300);
            }, 300);
        }
    }

    // Toast notification helper
    function showToast(message, type) {
        console.log(message, type);
        // You can integrate with toastr or your preferred notification system
        // Example: toastr[type](message);
    }
    </script>

    <script>
    $(document).ready(function() {


        /***************BreadCrumb Navigation *********************/

        var url = 0;
        var url = "{{ URL::to(strtolower($urlmenu['menu'])) }}";
        var check = "{{ $urlmenu['menu'] }}";
        <?php    if (!empty($pageMethod)) { ?>
        $('a[href="' + url + '"]').removeClass('menu3css');
        <?php  } ?>

        if (check != '') {


            $('a[href="' + url + '"]').addClass('active1');

            $('a[href="' + url + '"]').closest('.mega-parent').find('.menuhover').addClass('active1');


            var html = ' <li><a href="home">Home</a></li>';
            $('head title').text("L&T");
            if ($('a[href="' + url + '"]').text() != '') {

                var menu_text = $.trim($('a[href="' + url + '"]').text());
                menu_text = menu_text.slice(0, (menu_text.length) / 2);
                $('head title').text("L&T ");

                html += '<li><a href="#" onclick="return false;">' + $('a[href="' + url + '"]').closest(
                    '.mega-parent').find('.menuhover').html() + '</a></li>';
                html += '<li><a href="#" onclick="return false;">' + $('a[href="' + url + '"]').closest(
                    '.single-mega-item').find('.mega-title').find('.mega_sub_menu').html() + '</a></li>';
                html += '<li><a href="#" onclick="return false;">' + $('a[href="' + url + '"]').html() +
                    '</a></li>';
            } else {

                var url = "{{ $urlmenu['menu'] }}";
                url = $('a:contains("' + url + '")').attr('href');
                $('a[href="' + url + '"]').closest('.mega-parent').find('.menuhover').addClass('active1');
                $('a[href="' + url + '"]').addClass('active1');
                var menu_text = $.trim($('a[href="' + url + '"]').text());
                menu_text = menu_text.slice(0, (menu_text.length) / 2);
                $('head title').text("L&T ");
                html += '<li><a href="#" onclick="return false;">' + $('a[href="' + url + '"]').closest(
                    '.mega-parent').find('.menuhover').html() + '</a></li>';
                html += '<li><a href="#" onclick="return false;">' + $('a[href="' + url + '"]').closest(
                    '.single-mega-item').find('.mega-title').find('.mega_sub_menu').html() + '</a></li>';
                html += '<li><a href="#" onclick="return false;">' + $('a[href="' + url + '"]').html() +
                    '</a></li>';
            }

            <?php  if (!empty($urlmenu['check'])) { ?>
            html += "<li><a href='#' onclick='return false;'>{{ $urlmenu['label'] }}</a></li>";
            <?php } ?>
            $(".breadcrumb").html(html);
            /***************End BreadCrumb Navigation**********************/
        }
    });
    // document.addEventListener('contextmenu', function(e) {
    //   e.preventDefault();
    // });
    // $(document).keydown(function(e){
    //     if(e.which === 123){
    //       return false;
    //     }
    // });
    // $('.noti_lines').click(function() {
    //   var form_id = $(this).data('val');
    //   document.getElementById('noti-form' + form_id).submit();
    // });
    $('.noti_lines').click(function(e) {
        e.preventDefault();

        var form_id = $(this).data('val');
        var form = $('#noti-form' + form_id);
        var formData = form.serialize();
        var reference_url = form.find('[name="reference_url"]').val();

        $.ajax({
            url: "{{ url('notimessage-update') }}", // Laravel route URL
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
            },
            success: function(response) {
                console.log('Success:', response);
                window.location.replace(reference_url); // Redirect after update
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });



    $('#userprofileedit').click(function() {
        document.getElementById('userprofileedit-form').submit();
    });

    $('form').attr('autocomplete', 'off');
    $(document).on('click', '.contentonly', function() {

        var content = $(this).attr('href');
        $.get(content, function(data) {
            $('.contentdata').html(data);
        });
        return false;

    });
    $('input[type="file"]').change(function(e) {
        var filename = e.target.files[0].name;
        var size = e.target.files[0].size;
        var extension = filename.substr((filename.lastIndexOf('.') + 1));
        console.log(size);
        //alert(extension);
        if (extension != "pdf" && extension != "jpeg" && extension != "jpg" && extension != "png" &&
            extension != "csv" && extension != "php" && extension != "sql") {
            notyMsg("info", "Please select PDF file or image file formats only");
            $(this).val('');
        } else {
            if (size > 3e+6) {
                notyMsg("info", "Please select file with less than 3MB");
                $(this).val('');
            }
        }
    });

    $('input[type=text],textarea').on('keypress keyup change', function(e) {
        var causes = $(this).val();
        var allowed = 0; //allowed times
        var regex =
            /<script>|=|=Cal|=cal|=calc|=Calc|script|SCRIPT|www.|https?:\/\/[\-A-Za-z0-9+&@#\/%?=~_|$!:,.;]*/g; //match urls
        var textArea = causes.match(regex); // search string
        var htmlRegex = /<[^>]*>/g; // Matches any HTML tags
        var scriptRegex = /<script.*?>.*?<\/script>/gi; // Matches script tags

        if (htmlRegex.test(causes) || scriptRegex.test(causes) || (textArea && textArea.length > allowed)) {
            notyMsg('error', "Input contains HTML or script or URL elements, which are not allowed.");
            // alert('Input contains HTML or script elements, which are not allowed.');
            e.preventDefault(); // Prevent form submission
            document.querySelector('.save').disabled = true; // Disable submit button
        } else {
            document.querySelector('.save').disabled = false; // Enable submit button
        }
        // if (textArea && textArea.length > allowed) {
        //   notyMsg('error', "User Date Is invalid");
        //   $('.save').prop("disabled", true);
        //   e.preventDefault()
        // } else {
        //   $('.save').prop("disabled", false);
        // }
    });



    /***************To Show Success Notification ***********/
    function notyMsg(status, msg) {
        notif({
            type: status,
            msg: msg,
            /*width: "all",*/

            position: "right"
        });
    }
    /***************To Show Success Notification End ***********/
    function notyMsgs(status, msg) {
        notif({
            type: status,
            msg: msg,
            /*width: "all",*/

            timeout: 6500,
            position: "right"
        });
    }

    function cloneRow(cloneClass, cloneBody) {
        var cloned = $('.' + cloneClass).find('tr:eq(1)').clone();
        cloned.find("input[type=text],input[type=hidden], textarea,input[type=date],select").val("");
        cloned.appendTo('.' + cloneBody);
    }

    function notyMessage(status, message, red_url, create_url, edit_url) {
        swal({
            title: status,
            text: message,
            type: status,
            /*timer: 2e3 */
            showCancelButton: !0,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ok",
            cancelButtonText: "Create",
            confirmButtonText: "Ok",
            closeOnConfirm: !1,
            //timer: 2e3,
            closeOnCancel: !1
        })
        setTimeout(function() {
            //window.location.href=red_url;
        }, 2000);

        $(document).on('click', '.confirm', function() {
            window.location.href = red_url;
        });

        $(document).on('click', '.cancel', function() {
            window.location.href = create_url;
        });

        $(document).on('click', '.apply', function() {
            window.location.href = edit_url;
        });

    }

    function showcolumn(tableid) {
        $(document).on('click', ".showcolumn", function() {

            jQuery('#' + tableid).jqGrid('columnChooser');
        });
    }
    /***************To check product Already Selected ***********/
    function pdtcheck(spares_id, index) {
        var pdtcount = 0;
        $('.clone').each(function(ind, v) {
            var val = $(".bulk_spares_id" + ind).val();
            if ($.trim(val) != "" && val != null) {
                if (index != ind) {
                    if (val == spares_id) {
                        pdtcount++;
                    }
                }
            }
        });
        return pdtcount;
    }
    /***************To check product Already Selected ***********/
    function positioncheck(position, index) {
        var pdtcount = 0;
        $('.clone').each(function(ind, v) {
            var val = $(".bulk_position" + ind).val();
            if ($.trim(val) != "" && val != null) {
                if (index != ind) {
                    if (val == position) {
                        pdtcount++;
                    }
                }
            }
        });
        return pdtcount;
    }
    /***************To check invoice Already Selected ***********/
    function invcheck(invoice_hdr_id, index) {
        var pdtcount = 0;
        $('.clone').each(function(ind, v) {
            var val = $(".bulk_invoice_hdr_id" + ind).val();
            if ($.trim(val) != "" && val != null) {
                if (index != ind) {
                    if (val == invoice_hdr_id) {
                        pdtcount++;
                    }
                }
            }
        });
        return pdtcount;
    }
    /***************To check product type Already Selected in machine ***********/
    function prdtypecheck(product_type_id, index) {
        var pdtcount = 0;
        $('.bulk_product_type_id').each(function(ind, v) {
            var val = $(".bulk_product_type_id" + ind).val();

            if ($.trim(val) != "" && val != null) {

                if (index != ind) {
                    if (val == product_type_id) {
                        pdtcount++;
                    }
                }
            }
        });
        return pdtcount;
    }
    /***************To check allowance Already Selected ***********/
    function allowcheck(product_id, index) {
        var pdtcount = 0;
        $('.clone').each(function(ind, v) {
            var val = $(".bulk_allowance_id" + ind).val();
            if ($.trim(val) != "" && val != null) {
                if (index != ind) {
                    if (val == product_id) {
                        pdtcount++;
                    }
                }
            }
        });
        return pdtcount;
    }
    /***************To check deduction Already Selected ***********/
    function deductcheck(product_id, index) {
        var pdtcount = 0;
        $('.clone').each(function(ind, v) {
            var val = $(".bulk_deduction_id" + ind).val();
            if ($.trim(val) != "" && val != null) {
                if (index != ind) {
                    if (val == product_id) {
                        pdtcount++;
                    }
                }
            }
        });
        return pdtcount;
    }

    /***************To check Purchase invoice Already Selected ***********/
    function poinvcheck(invoice_hdr_id, index) {
        var pdtcount = 0;
        $('.clone').each(function(ind, v) {
            var val = $(".bulk_po_invoice_id" + ind).val();
            if ($.trim(val) != "" && val != null) {
                if (index != ind) {
                    if (val == invoice_hdr_id) {
                        pdtcount++;
                    }
                }
            }
        });
        return pdtcount;
    }
    /***************To check Batch Already Selected in material issue & material Receive***********/
    function batchnocheck(batch_number, index) {
        var bcount = 0;
        $('.clone').each(function(ind, v) {
            var val = $(".batch_number" + ind).val();
            if (index != ind) {
                if (val == batch_number) {
                    bcount++;
                }
            }
        });
        return bcount;
    }
    /*
    $( "select.select2" ).each(function( index, element ) {
              $(element).before('<div class="sel2" id="moved'+index+'">');
              $("#moved"+index).append(element);
            });*/
    var dateToday = new Date();
    var data = "{{ \Session::get('j_date_format') }}";

    $(".datepicker").datepicker({
        changeMonth: true,
        dateFormat: data,
        changeYear: true,
        minDate: dateToday,
        maxDate: null,
        onClose: function() {
            $(this).parsley().validate();
        }

    }).attr('readonly', 'readonly');
    $(".datepicker1").datepicker({
        changeMonth: true,
        dateFormat: data,
        changeYear: true,
        maxDate: 0,
        onClose: function() {
            $(this).parsley().validate();
        }

    }).attr('readonly', 'readonly');


    $(".previousdates").datepicker({
        changeYear: true,
        changeMonth: true,
        dataFormat: data,
        maxDate: 0
    }).attr('readonly', 'readonly');

    $('.datetimepickers').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        format: "yyyy-mm-dd hh:ii:ss",
        minView: 0,
        maxView: 1,
        forceParse: 0,

    }).on('change', function() {
        $(this).parsley().destroy();
    });

    $('.timepicker').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        autoclose: true,
        todayHighlight: 1,
        autoclose: true,
        startView: 1,
        format: 'dd-mm-yyyy hh:ii',
        forceParse: 1,
        showMeridian: 1
    });
    $('.timepicker2').datetimepicker({
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        format: 'dd-mm-yyyy hh:ii',
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
    /***************To check product Already Selected End***********/
    function notysuccess(message, status) {
        swal({
            position: 'top-right',
            type: status,
            title: message,
            showConfirmButton: false,
            timer: 1500

        });
    }

    function change_date() {
        $(".datepicker").each(function() {
            var myDate = $(this).val();
            var parsedDate = $.datepicker.parseDate("{{ \Session::get('j_date_format') }}", myDate);
            $(this).val($.datepicker.formatDate("yy-mm-dd", parsedDate));
        });
        $(".datepicker1").each(function() {
            var myDate = $(this).val();
            var parsedDate = $.datepicker.parseDate("{{ \Session::get('j_date_format') }}", myDate);
            $(this).val($.datepicker.formatDate("yy-mm-dd", parsedDate));
        });
    }

    $(document).ready(function() {
        $(".datepicker").each(function() {
            var myDate = $.trim($(this).val());
            if (myDate != '0000-00-00' && myDate != '') {
                var parsedDate = $.datepicker.parseDate("yy-mm-dd", myDate);
                $(this).val($.datepicker.formatDate("{{ \Session::get('j_date_format') }}",
                    parsedDate));
            } else {
                $(this).val('');
            }

        });
        $(".datepicker1").each(function() {
            var myDate = $.trim($(this).val());
            if (myDate != '0000-00-00' && myDate != '') {
                console.log(myDate);

                var parsedDate = $.datepicker.parseDate("yy-mm-dd", myDate);
                $(this).val($.datepicker.formatDate("{{ \Session::get('j_date_format') }}",
                    parsedDate));
            } else {
                $(this).val('');
            }

        });

    });
    </script>
    <a href="#" id="scroll" style="display: none;"><span></span></a>
    <style type="text/css">
    #scroll {
        position: fixed;
        right: 7px;
        bottom: 2.40em;
        cursor: pointer;
        width: 30px;
        height: 30px;
        background-color: rgba(0, 0, 0, 0.5);
        text-indent: -9999px;
        display: none;
        /*-webkit-border-radius:60px;
    -moz-border-radius:60px;
    border-radius:60px*/
    }

    #scroll span {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -12px;
        height: 0;
        width: 0;
        border: 8px solid transparent;
        border-bottom-color: #ffffff;
    }

    #scroll:hover {
        background-color: rgba(0, 18, 103, 0.59);
        ;
        opacity: 1;
        filter: "alpha(opacity=100)";
        -ms-filter: "alpha(opacity=100)";
    }

    .noti_lines {
        cursor: pointer;
    }
    </style>
    <script>
    // Toggle Notifications Dropdown
    function toggleNotifications(event) {
        event.preventDefault();
        event.stopPropagation();
        var dropdown = document.getElementById('notificationDropdown');
        var profileDropdown = document.getElementById('profileDropdown');

        // Close profile dropdown if open
        profileDropdown.style.opacity = '0';
        profileDropdown.style.visibility = 'hidden';
        profileDropdown.style.transform = 'translateY(-8px)';

        // Toggle notification dropdown
        if (dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        } else {
            dropdown.classList.add('show');
        }
    }

    // Toggle Profile Menu
    function toggleProfileMenu(event) {
        event.preventDefault();
        event.stopPropagation();
        var dropdown = document.getElementById('profileDropdown');
        var notificationDropdown = document.getElementById('notificationDropdown');

        // Close notification dropdown if open
        notificationDropdown.classList.remove('show');

        // Toggle profile dropdown
        if (dropdown.style.visibility === 'visible') {
            dropdown.style.opacity = '0';
            dropdown.style.visibility = 'hidden';
            dropdown.style.transform = 'translateY(-8px)';
        } else {
            dropdown.style.opacity = '1';
            dropdown.style.visibility = 'visible';
            dropdown.style.transform = 'translateY(0)';
        }
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        var notificationDropdown = document.getElementById('notificationDropdown');
        var profileDropdown = document.getElementById('profileDropdown');

        if (!event.target.closest('.notification-trigger') && !event.target.closest(
                '.notification-dropdown')) {
            notificationDropdown.classList.remove('show');
        }

        if (!event.target.closest('.topbar-profile') && !event.target.closest('#profileDropdown')) {
            profileDropdown.style.opacity = '0';
            profileDropdown.style.visibility = 'hidden';
            profileDropdown.style.transform = 'translateY(-8px)';
        }
    });

    // Mobile sidebar toggle
    document.getElementById('mobileSidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.mobile-Menu').style.display =
            document.querySelector('.mobile-Menu').style.display === 'none' ? 'block' : 'none';
    });
    </script>
    <!---------------------- Active menubar ---------------------->
    <script type="text/javascript">
    //$('.container').css("height", $(document).height(),"padding-bottom",);

    // $(document).ready(function(){

    // /*isac purpose: back button disable in all pages*/
    // history.pushState(null, null, location.href);
    //     window.onpopstate = function () {
    //         history.go(1);
    //     };
    //  /*end*/ 
    //     $(window).scroll(function(){
    //         if ($(this).scrollTop() > 80) {
    //             $('#scroll').fadeIn();
    //         } else {
    //             $('#scroll').fadeOut();
    //         }
    //     });
    //     $('#scroll').click(function(){
    //         $("html, body").animate({ scrollTop: 0 }, 600);
    //         return false;
    //     });
    // var end_actual_time = "{{$end_time}}";
    // var start_actual_time ="{{$start_time}}";
    // console.log(end_actual_time);

    // var interval=setInterval(function(){
    // start_actual_time = new Date(start_actual_time);
    // end_actual_time = new Date(end_actual_time);

    // var date=end_actual_time.getFullYear()+"-"+end_actual_time.getMonth()+1+"-"+end_actual_time.getDate()+" "+end_actual_time.getHours()+":"+end_actual_time.getMinutes()+":"+end_actual_time.getSeconds();


    // start_actual_time.setTime(start_actual_time.getTime() + (50000));



    // var diff = end_actual_time - start_actual_time;

    // var diffSeconds = diff / 1000;
    // var HH = Math.floor(diffSeconds / 3600);
    // var MM = Math.floor(diffSeconds % 3600) / 60;


    // if(HH < 0 && MM < 0)
    // {
    //     var url="{{URL::to('timeoutcheck')}}?time="+date;
    // $.get(url,function(data){
    //     if($.trim(data)=="1")
    //     {
    //       $('#logout_popup').modal('show');
    //       $('#seconds_time').countdowntimer({
    //       });

    //    var int=setInterval(function(){
    //      $(".sign_in").attr("disabled",true);
    //                       $.get('timeoutcheck?popup=ok',function(data){
    //                       });
    //  },60000);
    //     }
    //      else if($.trim(data)=="3")
    //     {
    //       $('#logout_popup').modal('show');
    //     $(".session_popup").html("your Session Has been Expired");
    //         clearInterval(interval);

    //     }
    //   else if($.trim(data['return'])=="4")
    //     {
    //      clearInterval(int);
    //       $('#logout_popup').modal('hide');
    //  end_actual_time=data['time'];
    //     }
    // });
    // }

    // }, 50000);

    // // function




    // });


    //for select2 validation required using parsley
    $(document).ready(function() {
        setInterval(function() {
            var id = ($('.button__badge').text());
            var url = "{{URL::to('getnoty')}}?id=" + id;
            $.get(url, function(data) {

                if (data['count'] != "0") {
                    $('.button__badge').text(data['count']);
                    $('.notification_home').html(data['html']);
                }
            });
        }, 10000);
        // $(".select2").change(function() {
        //             $(this).parsley().validate();
        //  });

        $("select").on("select2:close", function() {
            $(this).parsley().validate();
        });


        $('input').on("change", function() {


        });







        //End for select2 validation required using parsley



        window.Parsley.on('form:validated', function() {
            var classes = $(".card").closest("form").attr('id');
            //console.log(classes);

            /*
$('select').on('select2:select', function(evt) {

$("#"+classes).parsley().validate();
});
*/
            $(".has-submenu >.cg__subMenu >tr>td").addClass("hi");

        });





    });
    </script>


    @if (session()->has('message'))
    <script>
    notyMsg("error", "{{ session('message') }}");
    </script>
    @endif


    <style type="text/css">
    /* css for printing view table without header and breadcrumb navigation  */
    @media print {

        .m-header,
        .bread {
            display: none !important;
        }
    }
    </style>
    <!--line table automatic scrolling to last row by default -->
    <script type="text/javascript" src="{{ asset('js/scroll.js') }}"></script>
    <script type="text/javascript">
    $(document).on("select2:close", '.select2-hidden-accessible', function() {
        $(this).focus(function() {
            $(this).css("border", "1px solid red");
        });



    });
    </script>
</body>

</html>