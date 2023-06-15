<?php                                   
include("connect.php");

if(isset($_REQUEST['btnDelete']))
{
    $count1 = $_REQUEST['count'];
    
    for($i = 1;$i <= $count1;$i++)
    {
        $pid = "pid".$i;
        $chk = "chk".$i;
        if(isset($_REQUEST[$chk]))
        {
            $query = "DELETE FROM  user_data where id=".$_REQUEST[$pid];
        }
        mysqli_query($conn,$query);
        
    }
    location("manage_user_data.php?msg=3");
}

if(isset($_REQUEST['update']))
{
    $count1 = $_REQUEST['count'];
    
    for($i = 1;$i <= $count1;$i++)
    {
        $disp = "disp".$i;  
        $pid = "pid".$i;
        
        if(isset($_REQUEST[$disp]))
        {
            $disp1 = $_REQUEST[$disp];
        }
        
         $query = "update user_data set display_order=".$disp1." where id=".$_REQUEST[$pid];
        mysqli_query($conn,$query);

    }
        
        location("manage_user_data.php?msg=2");
}
$LeftLinkSection = 1;
$pagetitle="User Data";
$sel = "select * from user_data_new where user_id='".$_REQUEST['uid']."' AND session_id='".$_REQUEST['id']."' LIMIT 1 ";
$query= mysqli_query($conn,$sel);
if(mysqli_num_rows($query) <= 0)
{
    $sel= "select * from user_data where user_id='".$_REQUEST['uid']."' AND session_id='".$_REQUEST['id']."' GROUP BY duration, IF(duration='', id, 0)" ;

    if($_REQUEST['date_time_sort'] != "")
    {

        if($_REQUEST['date_time_sort'] == "desc")
        {
            $sel .= " order by date_time desc";
        }
        else
        {
            $sel .= " order by date_time asc";
        } 
    }
    else if($_REQUEST['acceleration_sort'] != "")
    {

        if($_REQUEST['acceleration_sort'] == "desc")
        {
            $sel .= " order by acceleration desc";
        }
        else
        {
            $sel .= " order by acceleration asc";
        } 
    }
    else if($_REQUEST['heartrate_sort'] != "")
    {

        if($_REQUEST['heartrate_sort'] == "desc")
        {
            $sel .= " order by heartrate desc";
        }
        else
        {
            $sel .= " order by heartrate asc";
        } 
    }
    else if($_REQUEST['respirationrate_sort'] != "")
    {

        if($_REQUEST['respirationrate_sort'] == "desc")
        {
            $sel .= " order by respirationrate desc";
        }
        else
        {
            $sel .= " order by respirationrate asc";
        } 
    }
    else if($_REQUEST['speed_sort'] != "")
    {

        if($_REQUEST['speed_sort'] == "desc")
        {
            $sel .= " order by speed desc";
        }
        else
        {
            $sel .= " order by speed asc";
        } 
    }
    else
    {
        $sel .= " order by duration,distance + 0";
    }

    $old_data = "yes";
}
 
//$result=$prs_pageing->number_pageing($sel,20000,10,'N','Y');
if($old_data == "yes")
{
    $result=$prs_pageing->number_pageing($sel,20,10,'N','Y');
}
else
{
    $result= mysqli_query($conn,$sel);
}


?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title><?php echo $pagetitle; ?> | <?php echo $SITE_NAME; ?></title>
    
    <!--[if lt IE 9]> <script src="assets/plugins/common/html5shiv.js" type="text/javascript"></script> <![endif]-->
    <script src="js/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css" />
    <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/open-sans.css">
    
    <link rel='stylesheet' type='text/css' href="css/uikit.min.css">
    <link rel="stylesheet" type="text/css" href="css/select2.css" />
    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css" />
    
    
    <link href="css/main.css" rel="stylesheet" type="text/css"/>
    <link href="css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="css/style_default.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144x144-precomposed.png">

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    
<SCRIPT language=javascript src="body.js"></SCRIPT>
<style type="text/css">
    th.sriting-icon.sorting {
    font-size: 18px;
}
th.sorting_asc {
    font-size: 18px;
}
.no-of-sessions{
    width:170px !important;
}
p.text_p strong {
    font-size: 16px;
}
th.sorting{
    font-size: 18px;   
}
tr.odd {
    font-size: 16px;
}
tr.even {
    font-size: 16px;
}
.text_p{
    font-size: 16px;
}
th.sriting-icon.no-of-sessions.sorting_desc{
    font-size: 18px;
}   
th.sriting-icon.sorting_desc{
    font-size: 18px;
}
th.sorting_desc{
    font-size: 18px;   
}
.action-tab:before{display:none;}
strong.link2 { background-color: #000000; padding: 3px 12px;color: #fff; width: 100%; }
.action-tab:before{display:none;}
a.link2 { width: 100%; text-decoration: none; padding: 10px; }
.col-md-12.main-pagination{display: flex;flex-wrap: wrap;justify-content: flex-end;padding-bottom: 15px;padding-right: 50px;}
/*
.highcharts-figure, .highcharts-data-table table {
    min-width: 50px; 
    max-width: 200px;
    margin: 1em auto;
}*/

#container {
    height: 400px;
}

.highcharts-tooltip h3 {
    margin: 0.3em 0;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #EBEBEB;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}


</style>
    <script type="text/javascript">
    
      var chart_ajax =  $.ajax({
                url: 'session_chart.php',
                type: 'POST',
                data: 'session_id=<?php echo $_REQUEST['id'];?>',
                success: function(response) {
                   $('#session_chart').html(response);
                   
                }
            });
      
    </script>
</head>

<body>

   <?php include("top.php"); ?>

    <div id="container">    <!-- Start : container -->

    <?php include("left.php"); ?>

        <div id="content">  <!-- Start : Inner Page Content -->

            <div class="container"> <!-- Start : Inner Page container -->

                <?php /* ?><div class="crumbs">    <!-- Start : Breadcrumbs -->
                    <ul id="breadcrumbs" class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="deskboard.php">Dashboard</a>
                        </li>
                        
                        <li class="current"><?php echo $pagetitle; ?></li>
                    </ul>

                </div> <?php */ ?> <!-- End : Breadcrumbs -->
                <div class="refresh-btn" style="margin-top: 30px;display: inherit;">
                    <a href="javascript:history.go(-1)">Back</a>
                </div>
                <div class="page-header">   <!-- Start : Page Header -->
                    
                    <div id="session_chart"></div>
                    

                </div>  <!-- End : Page Header -->
                <?php if(isset($_GET["msg"]) && $_GET["msg"]!='') { ?>
                <div class="alert alert-danger show">
                        <button class="close" data-dismiss="alert"></button>
                        
                          <span style="color:#CC6600;">
                          <?
                                    if($_GET["msg"]==1)
                                            echo "User Data Added Successfully.";
                                    elseif($_GET["msg"]==2)
                                            echo "User Data Updated Successfully.";
                                    elseif($_GET["msg"]==3)
                                            echo "User Data Deleted Successfully.";
                                    elseif($_GET["msg"]==4)
                                            echo "User Data with this name is already Exist.";  
                                    elseif($_GET["msg"]==5)
                                            echo "This User Data is in use. You can not delete this User Data.";    

                             ?>
                           </span>
                         
                 </div>
                 <?php } ?> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet box blue" style="border: 0px;">
                            <div class="portlet-title" style="background-color: #ffffff;border-bottom: 0px;">
                                <!--<div class="caption"><?php /* ?><i class="fa fa-table"></i><?php */ ?></div>-->
<a class="btn green pull-right" href="#" onClick="window.location.href='export_to_csv.php?user_id=<?php echo ($_REQUEST['uid']); ?>&session_id=<?php echo ($_REQUEST['id']); ?>'" style="background-color: #333333;">EXPORT</a>    
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12">
                                       <div class="col-md-12 main-pagination">
                                          <?php if($old_data == "yes")
                                                { 
                                                    echo $result[1]; 
                                                }?>
                                       </div>
                                    </div>
                                 </div>
                                <div class="table-responsive">
                                <form name="frmNewsList" method="post" action="">
                                    <table class="table table-striped table-bordered "><!-- DynamicTable -->
                                        <thead>                                            
                                        <tr>
                        <th width="25px">No.</th>


                                                    <th><a href="manage_user_data.php?id=<?php echo $_REQUEST['id'];?>&uid=<?php echo $_REQUEST['uid'];?>&date_time_sort=<?php if($_REQUEST['date_time_sort'] == 'desc'){ echo 'asc'; }else{ echo 'desc'; } ?>" style="color:#000">Date Time</a></th>
                                                    <th><a href="manage_user_data.php?id=<?php echo $_REQUEST['id'];?>&uid=<?php echo $_REQUEST['uid'];?>&acceleration_sort=<?php if($_REQUEST['acceleration_sort'] == 'desc'){ echo 'asc'; }else{ echo 'desc'; } ?>" style="color:#000">Acceleration</a></th>
                                                    <th><a href="manage_user_data.php?id=<?php echo $_REQUEST['id'];?>&uid=<?php echo $_REQUEST['uid'];?>&heartrate_sort=<?php if($_REQUEST['heartrate_sort'] == 'desc'){ echo 'asc'; }else{ echo 'desc'; } ?>" style="color:#000">Heartrate</a></th>
                                                    <th><a href="manage_user_data.php?id=<?php echo $_REQUEST['id'];?>&uid=<?php echo $_REQUEST['uid'];?>&respirationrate_sort=<?php if($_REQUEST['respirationrate_sort'] == 'desc'){ echo 'asc'; }else{ echo 'desc'; } ?>" style="color:#000">Respirationrate</a></th>
                                                    <th><a href="manage_user_data.php?id=<?php echo $_REQUEST['id'];?>&uid=<?php echo $_REQUEST['uid'];?>&speed_sort=<?php if($_REQUEST['speed_sort'] == 'desc'){ echo 'asc'; }else{ echo 'desc'; } ?>" style="color:#000">Speed</a></th>
                                                    <th>Loation</th>
                                                </tr>
                                                </thead>
                                        <tbody>
                                            
                          <?php $count=0; 
                          if($old_data == "yes")
                          {
                             while($get=mysqli_fetch_object($result[0])) 
                             {  
                                $count++;
                            ?>   
                             <tr>
                                <td align="center"><strong><?php echo $count;?>.</strong></td>                  
                                <td><strong><?php echo date("d-m-Y H:i A",strtotime($get->date_time)); ?></strong></td>
                                <td><strong><?php echo number_format($get->acceleration,3); ?> m\s<sup>2</sup></strong></td>
                                <td><strong><?php echo stripslashes($get->heartrate); ?> bpm</strong></td>
                                <td><strong><?php echo number_format($get->respirationrate,3); ?></strong></td>
                                <td><strong><?php echo number_format($get->speed,2); ?> km/h</strong></td>
                                <td><strong><?php echo stripslashes($get->location); ?></strong></td>
                             </tr>  

                            <?php   
                                }
                         }
                         else
                         {
                            while($get=mysqli_fetch_object($result)) 
                             {
                                    $acceleration = explode('~', $get->acceleration);
                                    $heartrate = explode('~', $get->heartrate);
                                    $respirationrate = explode('~', $get->respirationrate);
                                    $speed = explode('~', $get->speed);
                                    $location = explode('~', $get->location);

                                    array_pop($acceleration); 
                                    array_pop($heartrate); 
                                    array_pop($respirationrate); 
                                    array_pop($speed); 
                                    array_pop($location); 
                                   
                                    
                                    //print_r($acceleration);
                                    $all_rocord_array=[];
                                    for($i=0;$i<count($acceleration);$i++)
                                    {
                                        $all_record_array[]=array("acceleration"=>$acceleration[$i],"heartrate"=>$heartrate[$i],"respirationrate"=>$respirationrate[$i],"speed"=>$speed[$i],"location"=>$location[$i]);
                                       
                                    }

                                    if($_REQUEST['acceleration_sort'] != "")
                                    {
                                        if($_REQUEST['acceleration_sort'] == "desc")
                                        {
                                            array_multisort( array_column($all_record_array, "acceleration"), SORT_DESC, $all_record_array );
                                        }
                                        else
                                        {
                                            array_multisort( array_column($all_record_array, "acceleration"), SORT_ASC, $all_record_array );
                                        } 
                                    }
                                    else if($_REQUEST['heartrate_sort'] != "")
                                    {
                                        if($_REQUEST['heartrate_sort'] == "desc")
                                        {
                                             array_multisort( array_column($all_record_array, "heartrate"), SORT_DESC, $all_record_array );
                                        }
                                        else
                                        {
                                            array_multisort( array_column($all_record_array, "heartrate"), SORT_ASC, $all_record_array );
                                        } 
                                    }
                                    else if($_REQUEST['respirationrate_sort'] != "")
                                    {
                                        if($_REQUEST['respirationrate_sort'] == "desc")
                                        {
                                            array_multisort( array_column($all_record_array, "respirationrate"), SORT_DESC, $all_record_array );
                                        }
                                        else
                                        {
                                            array_multisort( array_column($all_record_array, "respirationrate"), SORT_ASC, $all_record_array );
                                        }
                                    }
                                    else if($_REQUEST['speed_sort'] != "")
                                    {
                                        if($_REQUEST['speed_sort'] == "desc")
                                        {
                                            array_multisort( array_column($all_record_array, "speed"), SORT_DESC, $all_record_array );
                                        }
                                        else
                                        {
                                           array_multisort( array_column($all_record_array, "speed"), SORT_ASC, $all_record_array );
                                        } 
                                    }
                                    

                                    for($j=0;$j<count($all_record_array);$j++)
                                    {
                                    
                                        $count++;
                                        ?>   
                                         <tr>
                                            <td align="center"><strong><?php echo $count;?>.</strong></td>                  
                                            <td><strong><?php echo date("d-m-Y H:i A",strtotime($get->date_time)); ?></strong></td>
                                            <td><strong><?php echo number_format($all_record_array[$j]['acceleration'],3); ?> m\s<sup>2</sup></strong></td>
                                            <td><strong><?php echo stripslashes($all_record_array[$j]['heartrate']); ?> bpm</strong></td>
                                            <td><strong><?php echo number_format($all_record_array[$j]['respirationrate'],3); ?></strong></td>
                                            <td><strong><?php echo number_format($all_record_array[$j]['speed'],2); ?> km/h</strong></td>
                                            <td><strong><?php echo stripslashes($all_record_array[$j]['location']); ?></strong></td>
                                         </tr>   

                                        <?php  
                                    }
                                    
                                    
                                }
                            } ?>    
                             </tbody>
                       </table>
              
                
                                 <div class="row"><div class="col-md-12">
                 <input type="hidden" name="count" id="count" value="<?php echo $count;?>" />   
                 <?php /* ?><input style="margin-right:7px;" type="submit" name="btnDelete" id="btnDelete" value="Delete"  onclick="return chkDelete();" class="btn red pull-left" />&nbsp;
                 <input style="margin-right:7px;" type="button" name="button2" id="button2" value="ADD NEW"  onclick="location.href='add_user_data.php?mode=add'" class="btn green pull-left" />
                                    &nbsp; 
                                 
                                 
                                            <input  type="submit" name="update" value="Update" class="btn blue pull-left" > <?php // $result[1] ?> <?php */ ?>                              
                                   <div class="col-md-12 main-pagination">
                                        <?php if($old_data == "yes")
                                                { 
                                                    echo $result[1]; 
                                                }?>
                                     </div>  
                                    </div></div>
                                    </form>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>  <!-- End : Inner Page container -->
            <a href="javascript:void(0);" class="scrollup">Scroll</a>
        </div>  <!-- End : Inner Page Content -->

    </div>  <!-- End : container -->
    
    <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="js/jquery.event.move.js"></script>
    <script type="text/javascript" src="js/lodash.compat.js"></script>
    <script type="text/javascript" src="js/respond.min.js"></script>
    <script type="text/javascript" src="js/excanvas.js"></script>
    <script type="text/javascript" src="js/breakpoints.js"></script>
    <script type="text/javascript" src="js/touch-punch.min.js"></script>
    
    <script type="text/javascript" src="js/select2.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/DT_bootstrap.js"></script>
      <script type="text/javascript" src="js/uikit.min.js"></script>
    
    <script type="text/javascript" src="js/jquery.uniform.min.js"></script>

    <script type="text/javascript" src="js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.2/js/uikit-icons.min.js"></script>

    <script type="text/javascript" src="js/plugins.js"></script>


    
    <script>
        $(document).ready(function(){
            App.init();
            DataTabels.init();
        });        
    </script>
    
<script>
    function chkSelectAll()
    {
            totchk=document.getElementById("count").value;
            if(document.getElementById("chkAll").checked==true)
            {
                    for(a=1;a<=totchk;a++)
                    {
                            chkname="chk"+a;
                            document.getElementById(chkname).checked=true;
                    }
            }
            else
            {
                    for(a=1;a<=totchk;a++)
                    {
                            chkname="chk"+a;
                            document.getElementById(chkname).checked=false;
                    }
            }
    }
    function chkDelete()
    {
            return confirm("Are you sure that you want to delete the selected User Data.");
    }
</script>   

<script type="text/javascript">
  function change_chart()
  {     
        distance_ck = 0;
        hr_ck = 0;
        rr_ck = 0;
        speed_ck = 0;
        rr_interval_ck = 0;
        calories_ck = 0;

        if($('#distance_ck').is(":checked")){
          distance_ck = 1;
        }
        if($('#hr_ck').is(":checked")){
          hr_ck = 1;
        }
        if($('#rr_ck').is(":checked")){
          rr_ck = 1;
        }
        if($('#speed_ck').is(":checked")){
          speed_ck = 1;
        }
        if($('#rr_interval_ck').is(":checked")){
          rr_interval_ck = 1;
        }
        if($('#calories_ck').is(":checked")){
          calories_ck = 1;
        }

            
        $.ajax({
          url: 'ajax_single_session_chart.php',
          type: 'POST',
          data: 'distance_ck='+distance_ck+'&hr_ck='+hr_ck+'&rr_ck='+rr_ck+'&speed_ck='+speed_ck+'&rr_interval_ck='+rr_interval_ck+'&calories_ck='+calories_ck,

          success: function(response) {
             $('#single_session_chart').html(response);
          }
      });
        
  }
</script> 

</body>
</html>
