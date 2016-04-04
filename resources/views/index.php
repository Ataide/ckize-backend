<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>AngularJs Cliente Tcc - Ataide Bastos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.min.css">
  </head>
  <body ng-app="authApp">
    <div id="wrapper" ng-controller="MainController">

      <header class="navbar navbar-inverse" ng-cloak ng-if="isAuthenticated()">

        <div class="container">

          <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <i class="fa fa-cog"></i>
            </button>

            <a href="./" class="navbar-brand navbar-brand-img">
              <img src="./img/logo.png" alt="MVP Ready">
            </a>
          </div> <!-- /.navbar-header -->


          <nav class="collapse navbar-collapse" role="navigation">

            <ul class="nav navbar-nav noticebar navbar-left">

              <li class="dropdown">
                <a href="./page-notifications.html" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell"></i>
                  <span class="navbar-visible-collapsed">&nbsp;Notifications&nbsp;</span>
                  <span class="badge badge-primary">3</span>
                </a>

                <ul class="dropdown-menu noticebar-menu noticebar-hoverable" role="menu">
                  <li class="nav-header">
                    <div class="pull-left">
                      Notifications
                    </div>

                    <div class="pull-right">
                      <a href="javascript:;">Mark as Read</a>
                    </div>
                  </li>

                  <li>
                    <a href="./page-notifications.html" class="noticebar-item">
                      <span class="noticebar-item-image">
                        <i class="fa fa-cloud-upload text-success"></i>
                      </span>
                      <span class="noticebar-item-body">
                        <strong class="noticebar-item-title">Templates Synced</strong>
                        <span class="noticebar-item-text">20 Templates have been synced to the Mashon Demo instance.</span>
                        <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 12 minutes ago</span>
                      </span>
                    </a>
                  </li>

                  <li>
                    <a href="./page-notifications.html" class="noticebar-item">
                      <span class="noticebar-item-image">
                        <i class="fa fa-ban text-danger"></i>
                      </span>
                      <span class="noticebar-item-body">
                        <strong class="noticebar-item-title">Sync Error</strong>
                        <span class="noticebar-item-text">5 Designs have been failed to be synced to the Mashon Demo instance.</span>
                        <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 20 minutes ago</span>
                      </span>
                    </a>
                  </li>

                  <li class="noticebar-menu-view-all">
                    <a href="./page-notifications.html">View All Notifications</a>
                  </li>
                </ul>
              </li>



              <li class="dropdown">
                <a href="./page-notifications.html" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope"></i>
                  <span class="navbar-visible-collapsed">&nbsp;Messages&nbsp;</span>
                </a>

                <ul class="dropdown-menu noticebar-menu noticebar-hoverable" role="menu">
                  <li class="nav-header">
                    <div class="pull-left">
                      Messages
                    </div>

                    <div class="pull-right">
                      <a href="javascript:;">New Message</a>
                    </div>
                  </li>

                  <li>
                    <a href="./page-notifications.html" class="noticebar-item">
                      <span class="noticebar-item-image">
                        <img src="./img/avatars/avatar-1-md.jpg" style="width: 50px" alt="">
                      </span>

                      <span class="noticebar-item-body">
                        <strong class="noticebar-item-title">New Message</strong>
                        <span class="noticebar-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</span>
                        <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 20 minutes ago</span>
                      </span>
                    </a>
                  </li>

                  <li>
                    <a href="./page-notifications.html" class="noticebar-item">
                      <span class="noticebar-item-image">
                        <img src="./img/avatars/avatar-2-md.jpg" style="width: 50px" alt="">
                      </span>

                      <span class="noticebar-item-body">
                        <strong class="noticebar-item-title">New Message</strong>
                        <span class="noticebar-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</span>
                        <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 5 hours ago</span>
                      </span>
                    </a>
                  </li>

                  <li class="noticebar-menu-view-all">
                    <a href="./page-notifications.html">View All Messages</a>
                  </li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-exclamation-triangle"></i>
                  <span class="navbar-visible-collapsed">&nbsp;Alerts&nbsp;</span>
                </a>

                <ul class="dropdown-menu noticebar-menu noticebar-hoverable" role="menu">
                  <li class="nav-header">
                    <div class="pull-left">
                      Alerts
                    </div>
                  </li>

                  <li class="noticebar-empty">
                    <h4 class="noticebar-empty-title">No alerts here.</h4>
                    <p class="noticebar-empty-text">Check out what other makers are doing on Explore!</p>
                  </li>
                </ul>
              </li>

            </ul>



            <ul class="nav navbar-nav navbar-right">

              <li>
                <a href="javsacript:;">About</a>
              </li>

              <li>
                <a href="javascript:;">Resources</a>
              </li>

              <li class="dropdown navbar-profile">
                <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                  <img src="./img/avatars/avatar-1-xs.jpg" class="navbar-profile-avatar" alt="">
                  <span class="navbar-profile-label">rod@rod.me &nbsp;</span>
                  <i class="fa fa-caret-down"></i>
                </a>

                <ul class="dropdown-menu" role="menu">

                  <li>
                    <a href="./page-profile.html">
                      <i class="fa fa-user"></i>
                      &nbsp;&nbsp;My Profile
                    </a>
                  </li>

                  <li>
                    <a href="./page-pricing.html">
                      <i class="fa fa-dollar"></i>
                      &nbsp;&nbsp;Plans & Billing
                    </a>
                  </li>

                  <li>
                    <a href="./page-settings.html">
                      <i class="fa fa-cogs"></i>
                      &nbsp;&nbsp;Settings
                    </a>
                  </li>

                  <li class="divider"></li>

                  <li>
                    <a href="" ng-click="logOut()">
                      <i class="fa fa-sign-out"></i>
                      &nbsp;&nbsp;Logout
                    </a>
                  </li>

                </ul>

              </li>

            </ul>

          </nav>

        </div> <!-- /.container -->

      </header>



      <div class="content">
        <div class="container">
          <div class="row">
            <div ui-view></div>
          </div>
        </div>
      </div>



    </div>



  </body>
  <script src="scripts/libs.min.js"></script>
  <script src="scripts/app.min.js"></script>
  <script>
  angular.module("authApp").constant("API_URL", 'api/');
  </script>


</html>
