<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/total/config.php');
// require_once "config.php";

session_start();
if (!isset($_SESSION['userid'])) {
  require_once("login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8" />
  <title><?php echo $title; ?></title>
  <meta name="description" content="Responsive, Bootstrap, BS4" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="<?php echo BASEURL; ?>/images/icon.png">

  <!-- style -->
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/material-design-icons/material-design-icons.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/ionicons/css/ionicons.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/simple-line-icons/css/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/bootstrap/dist/css/bootstrap.min.css" type="text/css" />

  <!-- build:css css/styles/app.min.css -->
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/styles/app.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/styles/style.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="<?php echo BASEURL; ?>/css/styles/font.css" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


</head>

<body>
  <div class="app" id="app">

    <!-- ############ LAYOUT START-->

    <!-- aside -->
    <div id="aside" class="app-aside modal md nav-expand black">
      <!-- fluid app aside -->
      <div class="navside dk" data-layout="column">
        <div class="navbar no-radius">
          <!-- brand -->
          <a href="<?php echo BASEURL; ?>/" class="navbar-brand">
            <img src="<?php echo BASEURL; ?>/images/logo_full_white.png" alt="Cyboz ERP">
          </a>
          <!-- / brand -->
        </div>
        <div data-flex class="hide-scroll">
          <nav class="scroll nav-stacked nav-stacked-rounded nav-color">

            <ul class="nav" data-ui-nav>
              <li class="nav-header hidden-folded">
                <span class="text-xs">Main New</span>
              </li>
              <li>
                <a href="<?php echo BASEURL; ?>/" class="b-danger">
                  <span class="nav-icon text-white no-fade">
                    <i class="ion-filing"></i>
                  </span>
                  <span class="nav-text">Dashboard</span>
                </a>
              </li>



              <li>
                <a class="b-info">
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon text-white no-fade">
                    <i class="ion-chatbubble-working"></i>
                  </span>
                  <span class="nav-text">CRM</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo BASEURL; ?>/customers">
                      <span class="nav-text">Contacts</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="b-warning">
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon text-white no-fade">
                    <i class="fa fa-building"></i>
                  </span>
                  <span class="nav-text">Production</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo BASEURL; ?>/items">
                      <span class="nav-text">Items</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li>
                <a href="<?php echo BASEURL; ?>/vehicles" class="b-warn">
                  <span class="nav-icon text-white no-fade">
                    <i class="ion-android-car"></i>
                  </span>
                  <span class="nav-text">Vehicles</span>
                </a>
              </li>

              <li>
                <a class="b-success">
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon text-white no-fade">
                    <i class="ion-cube"></i>
                  </span>
                  <span class="nav-text">Sales</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo BASEURL; ?>/quotation">
                      <span class="nav-text">Quotation</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/orders">
                      <span class="nav-text">Delivery Order</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/delivery_notes">
                      <span class="nav-text">Delivery Note</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/goods_retun_notes">
                      <span class="nav-text">GR Notes</span>
                    </a>
                  </li>
                </ul>
              </li>
              
              <li>
                <a class="b-primary">
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon text-white no-fade">
                    <i class="fa fa-file-text-o"></i>
                  </span>
                  <span class="nav-text">Invoicing</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo BASEURL; ?>/invoices">
                      <span class="nav-text">Invoices</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Credit Note</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Receipts</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Refund</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Account Statement</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li>
                <a class="b-success">
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon text-white no-fade">
                    <i class="fa fa-credit-card"></i>
                  </span>
                  <span class="nav-text">Voucher</span>
                </a>
                <ul class="nav-sub">

                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Dashboard</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Receipt Voucher</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Journal Voucher</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Payment Voucher</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Credit Note</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Debit Note</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li>
                <a class="b-warn">
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon text-white no-fade">
                    <i class="ion-ios-pulse-strong"></i>
                  </span>
                  <span class="nav-text">Reports</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Quotation</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Order</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Sales</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Transportation</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Receivable Report</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">GST Report</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li>
                <a class="b-success">
                  <span class="nav-caret">
                    <i class="fa fa-caret-down"></i>
                  </span>
                  <span class="nav-icon text-white no-fade">
                    <i class="fa fa-bank "></i>
                  </span>
                  <span class="nav-text">Accounting</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">PDC Receivable</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">PDC Payable</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Receivable Report</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Chart of Accounts</span>
                    </a>
                  </li>

                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Trial Balance</span>
                    </a>
                  </li>

                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Acc Statement</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Profit & Loss</span>
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo BASEURL; ?>/404">
                      <span class="nav-text">Balance Sheet</span>
                    </a>
                  </li>

                </ul>
              </li>

              <!-- <li>
                <a href="<?php // echo BASEURL; ?>/backup" class="b-danger">
                  <span class="nav-icon text-white no-fade">
                    <i class="ion-filing"></i>
                  </span>
                  <span class="nav-text">Backup</span>
                </a>
              </li> -->

              <li>
                <a href="<?php echo BASEURL; ?>/404" class="b-primary">
                  <span class="nav-icon text-white no-fade">
                    <i class="ion-gear-b"></i>
                  </span>
                  <span class="nav-text">Settings</span>
                </a>
              </li>

              <li>
                <a href="<?php echo BASEURL; ?>/404" class="b-danger">
                  <span class="nav-icon text-white no-fade">
                    <i class="fa fa-bars"></i>
                  </span>
                  <span class="nav-text">Activities</span>
                </a>
              </li>

              <li>
                <a href="http://cyboz.co.in/contact/" target="_blank" class="b-default">
                  <span class="nav-label">
                    <b class="label label-xs rounded success"></b>
                  </span>
                  <span class="nav-icon">
                    <i class="ion-chatbubble-working"></i>
                  </span>
                  <span class="nav-text">Support</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div data-flex-no-shrink>
          <div class="nav-fold dropup">
            <a data-toggle="dropdown">
              <div class="pull-left">
                <div class="inline"><span class="avatar w-40 grey">
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1) . substr($_SESSION['username'], -1)); ?></span></div>
              </div>
              <div class="clear hidden-folded p-x">
                <span class="block _500 text-muted"><?php echo ucwords($_SESSION['username']); ?></span>
                <div id="clock"></div>
              </div>
            </a>
            <div class="dropdown-menu w dropdown-menu-scale ">
              <a class="dropdown-item" href="<?php echo BASEURL; ?>/404">
                <span>Profile</span>
              </a>
              <a class="dropdown-item" href="<?php echo BASEURL; ?>/404">
                <span>Settings</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" target="_blank" href="http://cyboz.co.in/contact/">
                Need help?
              </a>
              <a class="dropdown-item" href="<?php echo BASEURL; ?>/logout">Sign out</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / -->
    <!-- content -->
    <div id="content" class="app-content box-shadow-z2 bg pjax-container" role="main">
      <div class="app-header white bg b-b">
        <div class="navbar" data-pjax>
          <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up p-r m-a-0">
            <i class="ion-navicon"></i>
          </a>
          <div class="navbar-item pull-left h5" id="pageTitle"> Total Engineering ERP</div>
          <!-- nabar right -->
          <ul class="nav navbar-nav pull-right">
            <style>
              .clockout {
                display: none;
              }
            </style>

            <li class="nav-item dropdown">
              <a class="nav-link clear" data-toggle="dropdown">
                <span class="avatar w-32">
                  <img src="images/user.png" class="w-full rounded" alt="...">
                </span>
              </a>
              <div class="dropdown-menu w dropdown-menu-scale pull-right">
                <a class="dropdown-item" href="#">
                  <span>Hello, <b><?php echo ucwords($_SESSION['username']); ?></b></span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo BASEURL; ?>/404">
                  <span>Profile</span>
                </a>
                <a class="dropdown-item" href="<?php echo BASEURL; ?>/404">
                  <span>Settings</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" target="_blank" href="http://cyboz.co.in/contact/">
                  Need help?
                </a>
                <a class="dropdown-item" href="<?php echo BASEURL; ?>/404">Reset Password</a>
                <a class="dropdown-item" href="<?php echo BASEURL; ?>/logout">Sign out</a>
              </div>
            </li>
          </ul>
          <!-- / navbar right -->
        </div>
      </div>
      <div class="app-footer white bg p-a b-t">
        <div class="pull-right text-sm text-muted"><?php echo $erp_version; ?></div>
        <span class="text-sm text-muted">&copy; Cyboz Technologies Pvt. Ltd.</span>
      </div>
      <script>
        var countDownDate = <?php echo $_SESSION['time'] * 1000; ?>;

        var x = setInterval(function() {
          var now = new Date().getTime();
          var distance = countDownDate - now + 1800000;

          var minutes = ("0" + Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).slice(-2);
          var seconds = ("0" + Math.floor((distance % (1000 * 60)) / 1000)).slice(-2);

          document.getElementById("clocktime").innerHTML = minutes + "m " + seconds + "s";
          if (distance < 0) {
            clearInterval(x);
            document.getElementById("clocktime").innerHTML = "Clocked!";
          }
        }, 1000);

        $('.clock').hover(function() {
          $(this).find('.clockin').hide();
          $(this).find('.clockout').show();
        }, function() {
          $(this).find('.clockout').hide();
          $(this).find('.clockin').show();
        });
      </script>


      <script type="text/javascript">
        let idle_reloader_timer = false
        const idle_reloader = (idle_reloader_timer) => {
          const run_idle_reloader = () => {
            clearTimeout(idle_reloader_timer)
            idle_reloader_timer = setTimeout(() => {
              $('form').each((index, form) => form.reset())
              /*alert('Dear MANCON user,You should reload due to security issue')*/
              window.location.href = "<?php echo BASEURL; ?>"
              idle_reloader()
            }, 20 * 60 * 1000)
          }
          document.onmousemove = (e) => run_idle_reloader()
          document.onkeyup = (e) => run_idle_reloader()
        }
        idle_reloader()
      </script>