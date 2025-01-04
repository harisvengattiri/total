<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<?php require_once "config.php"; ?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Cyboz ERP">
  <link rel="shortcut icon" href="<?php echo BASEURL; ?>/images/icon.png">
  <title><?php echo $title; ?></title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel='stylesheet' href='<?php echo BASEURL; ?>/css/styles/login-style.css'>
  <style>
    html {
      background-image: url("<?php echo BASEURL; ?>/images/login-bg.jpg");
      background-size: 100%;
      background-repeat: no-repeat;
    }
  </style>
</head>

<body>
  <div class="logmod">
    <div class="login_logo" align="center">
      <img src="<?php echo BASEURL; ?>/images/logo_full.png" alt="" />
    </div>
    <div class="logmod__wrapper">
      <div class="logmod__container">
        <ul class="logmod__tabs">
          <li data-tabtar="lgm-2"><a href="#">Login</a></li>
          <li data-tabtar="lgm-1"><a href="#">Sign Up</a></li>
        </ul>
        <div class="logmod__tab-wrapper">
          <div class="logmod__tab lgm-1">
            <div class="logmod__heading">
              <span class="logmod__heading-subtitle">Enter your personal details <strong>to create an acount</strong></span>
            </div>
            <div class="logmod__form">
              <form accept-charset="utf-8" class="simform">
                <div class="sminputs">
                  <div class="input full">
                    <label class="string optional" for="user-name">Email*</label>
                    <input class="string optional" readonly maxlength="255" id="user-email" placeholder="Email [Disabled]" type="email" size="50" />
                  </div>
                </div>
                <div class="sminputs">
                  <div class="input string optional">
                    <label class="string optional" for="user-pw">Password *</label>
                    <input class="string optional" readonly maxlength="255" id="user-pw" placeholder="Password [Disabled]" type="text" size="50" />
                  </div>
                  <div class="input string optional">
                    <label class="string optional" for="user-pw-repeat">Repeat password *</label>
                    <input class="string optional" readonly maxlength="255" id="user-pw-repeat" placeholder="Repeat password [Disabled]" type="text" size="50" />
                  </div>
                </div>
                <div class="simform__actions">
                  <input class="sumbit" name="commit" readonly value="Create Account [Disabled]" />
                  <span class="simform__actions-sidetext">Public Sign-Up disabled, send your queries to <a class="special" target="_blank" href="mailto:support@cyboz.org" role="link">support@cyboz.org</a></span>
                </div>
              </form>
            </div>
          </div>
          <div class="logmod__tab lgm-2">
            <div class="logmod__heading">
              <?php
              if ($_GET) {
                $status = $_GET['status'];
              } else {
                $status = NULL;
              }

              if ($status == 'failed') {
                echo '<div class="alert alert-danger"><i class="fa fa-user-times"></i><strong> Oops! </strong> Invalid Username or Password, Please Re-enter.</div>';
              }
              if ($status == 'logout') {
                echo '<div class="alert alert-info"><i class="fa fa-user-secret"></i><strong> Success! </strong> You have logged out Successfully.</div>';
              }
              ?>
              <span class="logmod__heading-subtitle">Enter your email and password <strong>to sign in</strong></span>
            </div>
            <div class="logmod__form">
              <form action="<?php echo BASEURL; ?>/login-check" method="post" class="simform">
                <div class="sminputs">
                  <div class="input full">
                    <label class="string optional" for="user-name">User Name*</label>
                    <input class="string optional" maxlength="255" name="username" id="user-email" placeholder="User Name" type="text" size="50" />
                  </div>
                </div>
                <div class="sminputs">
                  <div class="input full">
                    <label class="string optional" for="user-pw">Password *</label>
                    <input class="string optional" name="password" maxlength="255" id="user-pw" placeholder="Password" type="password" size="50" />
                    <span class="hide-password">Show</span>
                  </div>
                </div>
                <div class="simform__actions">
                  <input class="sumbit" name="commit" type="submit" name="login" value="Log In" />
                  <span class="simform__actions-sidetext">If you forgot the password, get assistance from <a class="special" target="_blank" href="mailto:support@cyboz.org" role="link">support@cyboz.org</a></span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    var LoginModalController = {
      tabsElementName: ".logmod__tabs li",
      tabElementName: ".logmod__tab",
      inputElementsName: ".logmod__form .input",
      hidePasswordName: ".hide-password",

      inputElements: null,
      tabsElement: null,
      tabElement: null,
      hidePassword: null,

      activeTab: null,
      tabSelection: 0, // 0 - first, 1 - second

      findElements: function() {
        var base = this;

        base.tabsElement = $(base.tabsElementName);
        base.tabElement = $(base.tabElementName);
        base.inputElements = $(base.inputElementsName);
        base.hidePassword = $(base.hidePasswordName);

        return base;
      },

      setState: function(state) {
        var base = this,
          elem = null;

        if (!state) {
          state = 0;
        }

        if (base.tabsElement) {
          elem = $(base.tabsElement[state]);
          elem.addClass("current");
          $("." + elem.attr("data-tabtar")).addClass("show");
        }

        return base;
      },

      getActiveTab: function() {
        var base = this;

        base.tabsElement.each(function(i, el) {
          if ($(el).hasClass("current")) {
            base.activeTab = $(el);
          }
        });

        return base;
      },

      addClickEvents: function() {
        var base = this;

        base.hidePassword.on("click", function(e) {
          var $this = $(this),
            $pwInput = $this.prev("input");

          if ($pwInput.attr("type") == "password") {
            $pwInput.attr("type", "text");
            $this.text("Hide");
          } else {
            $pwInput.attr("type", "password");
            $this.text("Show");
          }
        });

        base.tabsElement.on("click", function(e) {
          var targetTab = $(this).attr("data-tabtar");

          e.preventDefault();
          base.activeTab.removeClass("current");
          base.activeTab = $(this);
          base.activeTab.addClass("current");

          base.tabElement.each(function(i, el) {
            el = $(el);
            el.removeClass("show");
            if (el.hasClass(targetTab)) {
              el.addClass("show");
            }
          });
        });

        base.inputElements.find("label").on("click", function(e) {
          var $this = $(this),
            $input = $this.next("input");

          $input.focus();
        });

        return base;
      },

      initialize: function() {
        var base = this;

        base.findElements().setState().getActiveTab().addClickEvents();
      }
    };

    $(document).ready(function() {
      LoginModalController.initialize();
    });
  </script>

</body>

</html>