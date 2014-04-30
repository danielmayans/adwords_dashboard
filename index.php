<?php
session_start();

error_reporting(E_STRICT | E_ALL);

// Include the initialization file
include 'lib/getCampaigns.php';
include 'lib/tables.php';
require_once 'lib/class/KeywordData.class.php';
require_once 'lib/class/AdWordsAdapter.class.php';
require_once 'lib/credentialHandler.php';
require_once 'init.php';

require_once ADWORDS_UTIL_PATH . '/ReportUtils.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Minimal 1.0 - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />

    <link rel="icon" type="image/ico" href="lib/assets/images/favicon.ico" />
    <!-- Bootstrap -->
    <link href="lib/assets/css/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="lib/assets/css/vendor/animate/animate.min.css">
    <link type="text/css" rel="stylesheet" media="all" href="lib/assets/js/vendor/mmenu/css/jquery.mmenu.all.css" />
    <link rel="stylesheet" href="lib/assets/js/vendor/videobackground/css/jquery.videobackground.css">
    <link rel="stylesheet" href="lib/assets/css/vendor/bootstrap-checkbox.css">

    <link rel="stylesheet" href="lib/assets/js/vendor/rickshaw/css/rickshaw.min.css">
    <link rel="stylesheet" href="lib/assets/js/vendor/morris/css/morris.css">
    <link rel="stylesheet" href="lib/assets/js/vendor/tabdrop/css/tabdrop.css">
    <link rel="stylesheet" href="lib/assets/js/vendor/summernote/css/summernote.css">
    <link rel="stylesheet" href="lib/assets/js/vendor/summernote/css/summernote-bs3.css">
    <link rel="stylesheet" href="lib/assets/js/vendor/chosen/css/chosen.min.css">
    <link rel="stylesheet" href="lib/assets/js/vendor/chosen/css/chosen-bootstrap.css">

    <link href="lib/assets/css/minimal.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<style type="text/css">
.logout{color: #717171;border:0;background: transparent;width:88%;text-align: left;}
.user.open li:hover{background-color:#f2f2f2;}
</style>
  </head>
  <body class="bg-6">
    <?php
      try {
        
        checkLogout();
        $credentials = getCredentials();
        $CLIENT_ID = $credentials[0];
        $CLIENT_SECRET = $credentials[1];
        $REFRESH_TOKEN = $credentials[2];
        $DEVELOPER_TOKEN = $credentials[3];
        $CLIENT_CUSTOMER_ID = $credentials[4];

        $adwordsData = new AdWordsAdapter($CLIENT_ID,$CLIENT_SECRET,$REFRESH_TOKEN,$DEVELOPER_TOKEN,$CLIENT_CUSTOMER_ID);

        saveSession();

        $oauth2Info = array(
          'client_id' => $CLIENT_ID,
          'client_secret' => $CLIENT_SECRET,
          'refresh_token' => $REFRESH_TOKEN
        );

        // See AdWordsUser constructor
        $user = new AdWordsUser(NULL, NULL, NULL, $DEVELOPER_TOKEN, NULL, NULL,
            $CLIENT_CUSTOMER_ID, NULL, NULL, $oauth2Info);

        $user->LogAll();

        // Get the OAuth2 credential.
        RunExample($user);

        // Download the report to a file in the same directory as the example.
        $filePath = dirname(__FILE__) . '/report.xml';
        $reportFormat = 'XML';

        // Run the example.
        //$month="jan";
        $month=null;
        $keyData = DownloadCriteriaReportWithAwqlExample($user, $filePath, $reportFormat, $month);

        print("<script>var filePath = \"".$filePath."\"</script>");

      } catch (Exception $e) {
        printf("An error has occurred: %s\n", $e->getMessage());
        session_destroy();
      }
    ?>

    <!-- Preloader -->
    <div class="mask"><div id="loader"></div></div>
    <!--/Preloader -->

    <!-- Wrap all page content here -->
    <div id="wrap">
      <!-- Make page fluid -->
      <div class="row">
        <div class="navbar navbar-default navbar-fixed-top mm-fixed-top" role="navigation" id="navbar" style="background:transparent;">
          
          <div class="navbar-collapse" style="padding-top: 8px;">

            <ul class="nav navbar-nav quick-actions">
              
              <li class="dropdown divided">
                
                <a class="dropdown-toggle button" data-toggle="dropdown" href="#">
                  <i class="fa fa-tasks"></i>
                  <span class="label label-transparent-black">2</span>
                </a>

                <ul class="dropdown-menu wide arrow nopadding bordered animated fadeInDown">
                  <li><h1>You have <strong>2</strong> new tasks</h1></li>
                  <li>
                    <a href="#">
                      <div class="task-info">
                        <div class="desc">Layout</div>
                        <div class="percent">80%</div>
                      </div>
                      <div class="progress progress-striped progress-thin">
                        <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                          <span class="sr-only">40% Complete (success)</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="task-info">
                        <div class="desc">Schemes</div>
                        <div class="percent">15%</div>
                      </div>
                      <div class="progress progress-striped active progress-thin">
                        <div class="progress-bar progress-bar-cyan" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 15%">
                          <span class="sr-only">45% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="task-info">
                        <div class="desc">Forms</div>
                        <div class="percent">5%</div>
                      </div>
                      <div class="progress progress-striped progress-thin">
                        <div class="progress-bar progress-bar-orange" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 5%">
                          <span class="sr-only">5% Complete (warning)</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="task-info">
                        <div class="desc">JavaScript</div>
                        <div class="percent">30%</div>
                      </div>
                      <div class="progress progress-striped progress-thin">
                        <div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                          <span class="sr-only">30% Complete (danger)</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="task-info">
                        <div class="desc">Dropdowns</div>
                        <div class="percent">60%</div>
                      </div>
                      <div class="progress progress-striped progress-thin">
                        <div class="progress-bar progress-bar-amethyst" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li><a href="#">Check all tasks <i class="fa fa-angle-right"></i></a></li>
                </ul>

              </li>

              <li class="dropdown divided">
                
                <a class="dropdown-toggle button" data-toggle="dropdown" href="#">
                  <i class="fa fa-bell"></i>
                  <span class="label label-transparent-black">3</span>
                </a>

                <ul class="dropdown-menu wide arrow nopadding bordered">
                  <li><h1>You have <strong>3</strong> new notifications</h1></li>
                  
                  <li>
                    <a href="#">
                      <span class="label label-green"><i class="fa fa-user"></i></span>
                      New user registered.
                      <span class="small">18 mins</span>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <span class="label label-red"><i class="fa fa-power-off"></i></span>
                      Server down.
                      <span class="small">27 mins</span>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <span class="label label-orange"><i class="fa fa-plus"></i></span>
                      New order.
                      <span class="small">36 mins</span>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <span class="label label-cyan"><i class="fa fa-power-off"></i></span>
                      Server restared.
                      <span class="small">45 mins</span>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <span class="label label-amethyst"><i class="fa fa-power-off"></i></span>
                      Server started.
                      <span class="small">50 mins</span>
                    </a>
                  </li>

                   <li><a href="#">Check all notifications <i class="fa fa-angle-right"></i></a></li>
                </ul>

              </li>

              <li class="dropdown divided user" id="current-user">

                <a class="dropdown-toggle options" data-toggle="dropdown" href="#">
                  Mobincube <i class="fa fa-caret-down"></i>
                </a>
                
                <ul class="dropdown-menu arrow settings animated fadeInDown">

                  <li>
                    <a href="#"><i class="fa fa-user"></i> Profile</a>
                  </li>

                  <li>
                    <a href="#"><i class="fa fa-calendar"></i> Calendar</a>
                  </li>

                  <li>
                    <a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge badge-red animated bounceIn" id="user-inbox">3</span></a>
                  </li>

                  <li class="divider"></li>

                  <li style="padding: 0 12px;font-size;12px;">                    
                    <form method="post" action="index.php"><i class="fa fa-power-off"></i>
                      <input class="logout" type="submit" name="logout" value="LogOut" size="5"/>
                    </form>
                  </li>
                </ul>
              </li>
              
            </ul>

          </div>
          <!--/.nav-collapse -->
        </div>
        <!-- Page content -->
        <div id="content" class="col-md-12" style="margin-top:60px;">
          <!-- page header -->
          <div class="pageheader">
            

            <h2><i class="fa fa-tachometer"></i> AdWords Dashboard
            <span>Developed by Daniel Mayans</span></h2>          

          </div>
          <!-- /page header -->

          <!-- content main container -->
          <div class="main">



            <!-- cards -->
            <div class="row cards">
              <?php $keywords = $keyData->GetKeywordData(); ?>
              <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                <div class="card card-redbrown hover">
                  <div class="front"> 

                    <div class="media">        
                      <span class="pull-left">
                        <i class="fa fa-tags media-object"></i>
                      </span>

                      <div class="media-body">
                        <small>Keywords Active</small>                       
                        <h2 class="media-heading animate-number" data-value="<?php print($keyData->sumKeywords()) ?>" data-animation-duration="1500">0</h2>
                      </div>
                    </div> 

                    <div class="progress-list">
                      <div class="details">
                        <div class="title">This month plan %</div>
                      </div>
                      <div class="status pull-right bg-transparent-black-1">
                        <span class="animate-number" data-value="83" data-animation-duration="1500">0</span>%
                      </div>
                      <div class="clearfix"></div>
                      <div class="progress progress-little progress-transparent-black">
                        <div class="progress-bar animate-progress-bar" data-percentage="83%"></div>
                      </div>
                    </div>

                  </div>
                  <div class="back">
                    <a href="#">
                      <ul class="list-group">
                        <?php
                          foreach($keywords as $key){
                            foreach($key as $index=>$data){
                              if($index=="keywordPlacement"){
                                print("<li class=\"list-group-item\">".$data."</li>");
                              }
                            }
                          }
                        ?>
                      </ul>
                    </a>  
                  </div>
                </div>
              </div>


              <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                <div class="card card-blue hover">
                  <div class="front">        
                    
                    <div class="media">                  
                      <span class="pull-left">
                        <i class="fa fa-eye media-object"></i>
                      </span>

                      <div class="media-body">
                        <small>Total Impressions</small>
                        <h2 class="media-heading animate-number" data-value="<?php print($keyData->sumImpressions()) ?>" data-animation-duration="1500">0</h2>
                      </div>
                    </div> 

                    <div class="progress-list">
                      <div class="details">
                        <div class="title">This month plan %</div>
                      </div>
                      <div class="status pull-right bg-transparent-black-1">
                        <span class="animate-number" data-value="100" data-animation-duration="1500">0</span>%
                      </div>
                      <div class="clearfix"></div>
                      <div class="progress progress-little progress-transparent-black">
                        <div class="progress-bar animate-progress-bar" data-percentage="100%"></div>
                      </div>
                    </div>

                  </div>
                  <div class="back">
                    <a href="#">
                      <ul class="list-group">
                        <?php
                          foreach($keywords as $key){
                            print("<li class=\"list-group-item\"><span class=\"badge badge-cyan\">".$key["impressions"]."</span>".$key["keywordPlacement"]."</li>");
                          }
                        ?>
                      </ul>
                    </a>
                  </div>
                </div>
              </div>



              <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                <div class="card card-greensea hover">
                  <div class="front">        
                    
                    <div class="media">
                      <span class="pull-left">
                        <i class="fa fa-check-circle media-object"></i>
                      </span>

                      <div class="media-body">
                        <small>Total Clicks</small>
                        <h2 class="media-heading animate-number" data-value="<?php print($keyData->sumClicks()) ?>" data-animation-duration="1500">0</h2>
                      </div>
                    </div>

                    <div class="progress-list">
                      <div class="details">
                        <div class="title">This month plan %</div>
                      </div>
                      <div class="status pull-right bg-transparent-black-1">
                        <span class="animate-number" data-value="42" data-animation-duration="1500">0</span>%
                      </div>
                      <div class="clearfix"></div>
                      <div class="progress progress-little progress-transparent-black">
                        <div class="progress-bar animate-progress-bar" data-percentage="42%"></div>
                      </div>
                    </div>

                  </div>
                  <div class="back">
                    <a href="#">
                      <ul class="list-group">
                        <?php
                          foreach($keywords as $key){
                            print("<li class=\"list-group-item\"><span class=\"badge badge-greensea\">".$key["clicks"]."</span>".$key["keywordPlacement"]."</li>");
                          }
                        ?>
                      </ul>
                    </a>
                  </div>
                </div>
              </div>


              <div class="card-container col-lg-3 col-sm-6 col-xs-12">
                <div class="card card-slategray hover">
                  <div class="front"> 

                    <div class="media">                   
                      <span class="pull-left">
                        <i class="fa fa-eur media-object"></i>
                      </span>

                      <div class="media-body">
                        <small>Costs</small>
                        <h2 class="media-heading animate-number" data-value="<?php print($keyData->sumCosts()) ?>" data-animation-duration="1500"></h2>
                      </div>
                    </div> 

                    <div class="progress-list">
                      <div class="details">
                        <div class="title">This month plan %</div>
                      </div>
                      <div class="status pull-right bg-transparent-black-1">
                        <span class="animate-number" data-value="25" data-animation-duration="1500">0</span>%
                      </div>
                      <div class="clearfix"></div>
                      <div class="progress progress-little progress-transparent-black">
                        <div class="progress-bar animate-progress-bar" data-percentage="25%"></div>
                      </div>
                    </div>

                  </div>
                  <div class="back">
                    <a href="#">
                      <ul class="list-group">
                        <?php
                          foreach($keywords as $key){
                            print("<li class=\"list-group-item\"><span class=\"badge badge-green\">".$key["costs"]."&nbsp;<i class=\"fa fa-eur media-object\"></i></span>".$key["keywordPlacement"]."</li>");
                          }
                        ?>
                      </ul>
                    </a>
                  </div>
                </div>
              </div>


            </div>
            <!-- /cards -->
            
            


            <!-- row -->
            <div class="row">


              <!-- col 8 -->
              <div class="col-lg-8 col-md-12">




                <!-- tile -->
                <section class="tile transparent">

                  <div class="tile-header color transparent-black textured rounded-top-corners">
                    <h1><strong>Statistic</strong> Chart</h1>
                    <div class="controls">
                      <a href="#" class="refresh"><i class="fa fa-refresh"></i></a>
                      <a href="#" class="remove"><i class="fa fa-times"></i></a>
                    </div>

<!--
                    <ul class="nav nav-tabs nav-separated" style="float: right;">
                      <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          Date Range <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" style="z-index: 1001;">
                          <li role="presentation" class="dropdown-header">Last Months</li>
                          <li><a href="#">1</a></li>
                          <li><a href="#">3</a></li>
                          <li><a href="#">6</a></li>
                          <li><a href="#">9</a></li>
                          <li class="divider"></li>
                          <li><a href="#">Last year</li>
                        </ul>
                      </li>
                    </ul>
                    -->
                  </div>

                  <!-- tile widget -->
                  <div class="tile-widget color transparent-black textured">
                    <div id="statistics-chart" class="chart statistics" style="height: 250px;"></div>
                  </div>
                  <!-- /tile widget -->

                </section>
                <!-- /tile -->

              </div>
              <!-- /col 8 -->

              <!-- col 4 -->
              <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">

                <!-- tile -->
                <section class="tile color transparent-black">

                  <!-- tile header -->
                  <div class="tile-header">
                    <h1><strong>Costs</strong> Percentage</h1>
                    <div class="controls">
                      <a href="#" class="refresh"><i class="fa fa-refresh"></i></a>
                      <a href="#" class="remove"><i class="fa fa-times"></i></a>
                    </div>
                  </div>
                  <!-- /tile header -->

                  <!-- tile body -->
                  <div class="tile-body">
                    <div id="browser-usage" style="height: 230px;" class="morris-chart"></div>
                    <ul class="inline text-center chart-legend">
                      <?php 
                      $percentages = $keyData->costPercent($keyData->sumCosts());
                      foreach($percentages as $percentArrays){
                        foreach($percentArrays as $in=>$val){                 
                          if($in==0){
                            if($percentArrays[$in+1]!=0)
                              print("<li style=\"text-transform:capitalize;\"><span class=\"badge badge-outline\" style=\"border-color: #fff;\"></span>".$val);
                          }
                          if($in==1){
                            if($val!=0){
                              print(" <small>".round($val, 2)."</small></li>");
                            }
                          }
                        }
                      }
                    ?>
                    </ul>
                  </div>
                  <!-- /tile body --> 
                </section>
                <!-- /tile -->
 <!-- tile -->
                <section class="tile color transparent-black textured">


                  <!-- tile header -->
                  <div class="tile-header">
                    <h1><strong>Server</strong> Load</h1>
                    <div class="controls">
                      <a href="#" class="refresh"><i class="fa fa-refresh"></i></a>
                      <a href="#" class="remove"><i class="fa fa-times"></i></a>
                    </div>
                  </div>
                  <!-- /tile header -->

                  <!-- tile widget -->
                  <div class="tile-widget">

                    <div class="progress-list with-heading">
                      <div class="details">
                        <div class="title"><h2><i class="fa fa-hdd-o"></i> <span class="animate-number" data-value="394" data-animation-duration="1600">0</span> GB</h2></div>
                      </div>
                      <div class="status pull-right bg-transparent-black-1">
                        <span class="animate-number" data-value="42" data-animation-duration="1500">0</span>%
                      </div>
                      <div class="clearfix"></div>
                      <div class="progress progress-little progress-transparent-black" style="margin-bottom: 5px">
                        <div class="progress-bar animate-progress-bar" data-percentage="42%"></div>
                      </div>
                    </div>  
                    <p class="description"><strong>394GB</strong> used of <strong class="white-text">2,048GB</strong> on File Server</p>
                  </div>
                  <!-- /tile widget -->


                  <!-- tile body -->
                  <div class="tile-body paddingtop">
                    <div id="serverload-chart"></div>
                  </div>
                  <!-- /tile body -->             

                </section>
                <!-- /tile -->
              </div>
              <!-- /col 4 -->
              
              
            </div>
            <!-- /row -->

          </div>
          <!-- /content container -->
        </div>
        <!-- Page content end -->
      </div>
      <!-- Make page fluid-->
    </div>
    <!-- Wrap all page content end -->
    <section class="videocontent" id="video"></section>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="lib/assets/js/vendor/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/assets/js/vendor/mmenu/js/jquery.mmenu.min.js"></script>
    <script type="text/javascript" src="lib/assets/js/vendor/sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="lib/assets/js/vendor/nicescroll/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="lib/assets/js/vendor/animate-numbers/jquery.animateNumbers.js"></script>
    <script type="text/javascript" src="lib/assets/js/vendor/videobackground/jquery.videobackground.js"></script>
    <script type="text/javascript" src="lib/assets/js/vendor/blockui/jquery.blockUI.js"></script>

    <script src="lib/assets/js/vendor/flot/jquery.flot.min.js"></script>
    <script src="lib/assets/js/vendor/flot/jquery.flot.time.min.js"></script>
    <script src="lib/assets/js/vendor/flot/jquery.flot.selection.min.js"></script>
    <script src="lib/assets/js/vendor/flot/jquery.flot.animator.min.js"></script>
    <script src="lib/assets/js/vendor/flot/jquery.flot.orderBars.js"></script>
    <script src="lib/assets/js/vendor/easypiechart/jquery.easypiechart.min.js"></script>

    <script src="lib/assets/js/vendor/rickshaw/raphael-min.js"></script> 
    <script src="lib/assets/js/vendor/rickshaw/d3.v2.js"></script>
    <script src="lib/assets/js/vendor/rickshaw/rickshaw.min.js"></script>

    <script src="lib/assets/js/vendor/morris/morris.min.js"></script>

    <script src="lib/assets/js/vendor/tabdrop/bootstrap-tabdrop.min.js"></script>

    <script src="lib/assets/js/vendor/summernote/summernote.min.js"></script>

    <script src="lib/assets/js/vendor/chosen/chosen.jquery.min.js"></script>

    <script src="lib/assets/js/minimal.min.js"></script>

    <script>
    $(function(){

     var reportAlert = $('<div/>');
    reportAlert.html('<div class="alert alert-success"><strong>Heads up!</strong> Report was downloaded to <a href="#" class="alert-link">'+filePath+'</a> succesfully.</div>').css("float","left").attr("float","left");
    $('.navbar').prepend(reportAlert);

    reportAlert.fadeIn(500).delay(5000).queue(function(n) {
      $(this).fadeOut(1000); n();
    });

      $('span.badge.badge-outline').eq(0).css("border-color","#00a3d8");
      $('span.badge.badge-outline').eq(1).css("border-color","#1693A5");
      $('span.badge.badge-outline').eq(2).css("border-color","#2fbbe8");
      $('span.badge.badge-outline').eq(3).css("border-color","#72cae7");
      $('span.badge.badge-outline').eq(4).css("border-color","#ffc100");

      // Initialize card flip
      /*
      $('.card.hover').hover(
        function(){
          var bgColor = $(this).find('.front').css("background-color");

          $(this).find('.back').css("background-color",bgColor);
          $(this).find('.list-group').css("color",bgColor);
          $(this).addClass('flip');
          var cardHeight = $(this).find(".back").height()-113;
          cardHeight = (cardHeight.toString())+"px";

          $('.row.cards').next().animate({
            marginTop:cardHeight
          },800);
        },
        function(){
          $(this).removeClass('flip');
          $('.row.cards').next().animate({
            marginTop:"0"
          },800);          
      });
      */
 <?php
  $costs = $keyData->getCosts();
  print("var nCostArray = []; var vCostArray = [];\n");
  $c=0;
  foreach($costs as $data){
    foreach($data as $in=>$val){
      if($in==0){                          
        print("nCostArray[".$c."]=\"".$val."\";");
      }else{
        print("vCostArray[".$c."]=\"".$val."\";\n");
      }
    }
    $c++;
  }

  $imps = $keyData->getImpressions();
  print("var nImpArray = []; var vImpArray = [];\n");
  $c=0;
  foreach($imps as $data){
    foreach($data as $in=>$val){
      if($in==0){                          
        print("nImpArray[".$c."]=\"".$val."\";");
      }else{
        print("vImpArray[".$c."]=\"".round(($val/1000),2)."\";\n");
      }
    }
    $c++;
  }
  ?>
  Morris.Bar({
              element: 'statistics-chart',
              data:[   
          {y: nCostArray[0], a: vCostArray[0], b:vImpArray[0]},
          {y: nCostArray[1], a: vCostArray[1], b:vImpArray[1]},
          {y: nCostArray[2], a: vCostArray[2], b:vImpArray[2]},
          {y: nCostArray[3], a: vCostArray[3], b:vImpArray[3]},
          {y: nCostArray[4], a: vCostArray[4], b:vImpArray[4]},
          {y: nCostArray[5], a: vCostArray[5], b:vImpArray[5]},
          {y: nCostArray[6], a: vCostArray[6], b:vImpArray[6]}
        ],
        xkey: 'y',
        ykeys: ['a','b'],
        labels: ['Cost', 'Impressions'],
        barColors: ['#ff4a43','#1693A5']
      });

      // Initialize flot chart
      var d1 =[ [1, 715],
            [2, 985],
            [3, 1525],
            [4, 1254],
            [5, 1861],
            [6, 2621],
            [7, 1987],
            [8, 2136],
            [9, 2364],
            [10, 2851],
            [11, 1546],
            [12, 2541]
      ];
      var d2 =[ [1, 463],
                [2, 578],
                [3, 327],
                [4, 984],
                [5, 1268],
                [6, 1684],
                [7, 1425],
                [8, 1233],
                [9, 1354],
                [10, 1200],
                [11, 1260],
                [12, 1320]
      ];
      var months = ["January", "February", "March", "April", "May", "Juny", "July", "August", "September", "October", "November", "December"];
/*
      // flot chart generate
      var plot = $.plotAnimator($("#statistics-chart"), 
        [
          {
            label: 'Sales', 
            data: d1,    
            lines: {lineWidth:3}, 
            shadowSize:0,
            color: '#ffffff'
          },
          { label: "Visits",
            data: d2, 
            animator: {steps: 99, duration: 500, start:200, direction: "right"},   
            lines: {        
              fill: .15,
              lineWidth: 0
            },
            color:['#ffffff']
          },{
            label: 'Sales',
            data: d1, 
            points: { show: true, fill: true, radius:6,fillColor:"rgba(0,0,0,.5)",lineWidth:2 }, 
            color: '#fff',        
            shadowSize:0
          },
          { label: "Visits",
            data: d2, 
            points: { show: true, fill: true, radius:6,fillColor:"rgba(255,255,255,.2)",lineWidth:2 }, 
            color: '#fff',        
            shadowSize:0
          }
        ],{ 
        
        xaxis: {

          tickLength: 0,
          tickDecimals: 0,
          min:1,
          ticks: [[1,"JAN"], [2, "FEB"], [3, "MAR"], [4, "APR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AUG"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DEC"]],

          font :{
            lineHeight: 24,
            weight: "300",
            color: "#ffffff",
            size: 14
          }
        },
        
        yaxis: {
          ticks: 4,
          tickDecimals: 0,
          tickColor: "rgba(255,255,255,.3)",

          font :{
            lineHeight: 13,
            weight: "300",
            color: "#ffffff"
          }
        },
        
        grid: {
          borderWidth: {
            top: 0,
            right: 0,
            bottom: 1,
            left: 1
          },
          borderColor: 'rgba(255,255,255,.3)',
          margin:0,
          minBorderMargin:0,              
          labelMargin:20,
          hoverable: true,
          clickable: true,
          mouseActiveRadius:6
        },
        
        legend: { show: false}
      });
*/
      $(window).resize(function() {
        // redraw the graph in the correctly sized div
        plot.resize();
        plot.setupGrid();
        plot.draw();
      });

      $('#mmenu').on(
        "opened.mm",
        function()
        {
          // redraw the graph in the correctly sized div
          plot.resize();
          plot.setupGrid();
          plot.draw();
        }
      );

      $('#mmenu').on(
        "closed.mm",
        function()
        {
          // redraw the graph in the correctly sized div
          plot.resize();
          plot.setupGrid();
          plot.draw();
        }
      );

      // tooltips showing
      $("#statistics-chart").bind("plothover", function (event, pos, item) {
        if (item) {
          var x = item.datapoint[0],
              y = item.datapoint[1];

          $("#tooltip").html('<h1 style="color: #418bca">' + months[x - 1] + '</h1>' + '<strong>' + y + '</strong>' + ' ' + item.series.label)
            .css({top: item.pageY-30, left: item.pageX+5})
            .fadeIn(200);
        } else {
          $("#tooltip").hide();
        }
      });

      
      //tooltips options
      $("<div id='tooltip'></div>").css({
        position: "absolute",
        //display: "none",
        padding: "10px 20px",
        "background-color": "#ffffff",
        "z-index":"99999"
      }).appendTo("body");

      //generate actual pie charts
      $('.pie-chart').easyPieChart();


      //server load rickshaw chart
      var graph;

      var seriesData = [ [], []];
      var random = new Rickshaw.Fixtures.RandomData(50);

      for (var i = 0; i < 50; i++) {
        random.addData(seriesData);
      }

      graph = new Rickshaw.Graph( {
        element: document.querySelector("#serverload-chart"),
        height: 150,
        renderer: 'area',
        series: [
          {
            data: seriesData[0],
            color: '#6e6e6e',
            name:'File Server'
          },{
            data: seriesData[1],
            color: '#fff',
            name:'Mail Server'
          }
        ]
      } );

      var hoverDetail = new Rickshaw.Graph.HoverDetail( {
        graph: graph,
      });

      setInterval( function() {
        random.removeData(seriesData);
        random.addData(seriesData);
        graph.update();

      },1000);

      // Morris donut chart
      <?php
      print("var keyNamePercent=[];var keyNumPercent=[];\n");
        $keyNamePercent=array();
        $keyNumPercent=array();
        $cnt=0;
        foreach($percentages as $percentArrays){
          foreach($percentArrays as $in=>$val){                 
            if($in==0){
              if($percentArrays[$in+1]!=0)
                print("keyNamePercent[".$cnt."]=\"".$val."\";\n");
            }
            if($in==1){
              if($val!=0){
                print("keyNumPercent[".$cnt."]=".$val.";\n");
              }
            }
          }
            $cnt++;
        }
       ?>
      Morris.Donut({
        element: 'browser-usage',
        data: [
          {label: keyNamePercent[1], value: parseFloat(keyNumPercent[1]).toFixed(2)},
          {label: keyNamePercent[2], value: parseFloat(keyNumPercent[2]).toFixed(2)},
          {label: keyNamePercent[3], value: parseFloat(keyNumPercent[3]).toFixed(2)},
          {label: keyNamePercent[5], value: parseFloat(keyNumPercent[5]).toFixed(2)},
          {label: keyNamePercent[6], value: parseFloat(keyNumPercent[6]).toFixed(2)}
        ],
        colors: ['#00a3d8', '#2fbbe8', '#72cae7', '#d9544f', '#ffc100', '#1693A5']
      });

      $('#browser-usage').find("path[stroke='#ffffff']").attr('stroke', 'rgba(0,0,0,0)');

      //sparkline charts
      $('#projectbar1').sparkline('html', {type: 'bar', barColor: '#22beef', barWidth: 4, height: 20});
      $('#projectbar2').sparkline('html', {type: 'bar', barColor: '#cd97eb', barWidth: 4, height: 20});
      $('#projectbar3').sparkline('html', {type: 'bar', barColor: '#a2d200', barWidth: 4, height: 20});
      $('#projectbar4').sparkline('html', {type: 'bar', barColor: '#ffc100', barWidth: 4, height: 20});
      $('#projectbar5').sparkline('html', {type: 'bar', barColor: '#ff4a43', barWidth: 4, height: 20});
      $('#projectbar6').sparkline('html', {type: 'bar', barColor: '#a2d200', barWidth: 4, height: 20});

      // sortable table
      $('.table.table-sortable th.sortable').click(function() {
        var o = $(this).hasClass('sort-asc') ? 'sort-desc' : 'sort-asc';
        $('th.sortable').removeClass('sort-asc').removeClass('sort-desc');
        $(this).addClass(o);
      });

      //todo's
      $('#todolist li label').click(function() {
        $(this).toggleClass('done');
      });

      // Initialize tabDrop
      $('.tabdrop').tabdrop({text: '<i class="fa fa-th-list"></i>'});

      //load wysiwyg editor
      $('#quick-message-content').summernote({
        toolbar: [
          //['style', ['style']], // no style button
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']],
          //['insert', ['picture', 'link']], // no insert buttons
          //['table', ['table']], // no table button
          //['help', ['help']] //no help button
        ],
        height: 143   //set editable area's height
      });

      //multiselect input
      $(".chosen-select").chosen({disable_search_threshold: 10});
    })
      
    </script>

  </body>

</html>
