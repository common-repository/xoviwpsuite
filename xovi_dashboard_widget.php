<?php

$xovi_options = get_option("xovi_options_vars");

if(empty($xovi_options["xovi[apitoken]"])) {
    echo sprintf('<div id="setting-error-settings_updated" class="%1$s"> 
                       <p style="text-align:center"><strong>%2$s</strong></p>
                    </div><br /><br />', 'update',_('Kein API-Token hinterlegt!', 'xovi'));
    
    return;
}
?>
<h2 class="nav-tab-wrapper">
<?php




$xovi_tabcontent = xovi_myDashboardTools($xovi_options['xovi[dashboardwidgets]']);

$xovi_currentWidget = (!empty($_GET['xovi_widget'])) ? $_GET['xovi_widget'] : $xovi_tabcontent[0];
       
foreach($xovi_tabcontent as $title) {
        
        $className = ($title == $xovi_currentWidget) ? "nav-tab nav-tab-active" : "nav-tab";
        $tablink = ($title == $xovi_currentWidget) ?  "#" : admin_url("index.php?xovi_widget=".$title,__FILE__);
    

    echo sprintf('<a href="%1$s" class="%2$s">%3$s</a>',$tablink, $className, $title);



}    


?>
</h2>
<table>
    <thead></thead>
    <tfoot></tfoot>
    <tbody>    
        <tr>
            <td>
                
        
<?php


if($xovi_currentWidget == "Credits") {
    include(__DIR__."/xovi_credittable.php");
}

if($xovi_currentWidget == "SEO Trends") {

$xovi_chartscript = <<<JAVASCRIPT
<script type="text/javascript">
    var chartData = [];
        chartData['ovi'] = %1\$s;
        chartData['dom'] = %2\$s;
   
    jQuery(document).ready(function() {     
        console.log(chartData);

        createChart(chartData['ovi']);
        createChart(chartData['dom']);
    });
</script>
JAVASCRIPT;


$xovi_oviChart = xovi_createOvitrendChart();
$xovi_domChart = xovi_createDomaintrendChart();

    if(!empty($xovi_oviChart) && !empty($xovi_domChart)) {

        echo sprintf($xovi_chartscript,  $xovi_oviChart, $xovi_domChart);
        echo '<div class="xovichart_dashboard" id="xovichart_ovitrend"></div><br /><div class="xovichart_dashboard" id="xovichart_domaintrend"></div>';

    } else {
        echo xovi_createMessage(__('No Data available!','xovi'), 'error');    
    }   
}
if($xovi_currentWidget == "Keyword Monitoring") {

    // MONITOR

    $xovi_myDailyKeywords = xovi_myDailyKeywords();    
    if(!empty($xovi_myDailyKeywords)) {        
?>

                <table class="wp-list-table widefat fixed" cellspacing="0">
                    <thead>
                        <tr>            
                            <th scope="col" id="" class="xovi_mediumColumn"><?php echo __('Keyword','xovi');?></th>                                              
                            <th scope="col" id="" class="xovi_shortColumn" style="text-align:right;"><?php echo __('Position','xovi');?></th>
                            <th scope="col" id="" class="xovi_shortColumn" style="text-align:center;">&plusmn;</th>            
                            <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('URL','xovi');?></th>      
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th scope="col" id="" class="xovi_mediumColumn"><?php echo __('Keyword','xovi');?></th>                                              
                            <th scope="col" id="" class="xovi_shortColumn" style="text-align:right;"><?php echo __('Position','xovi');?></th>
                            <th scope="col" id="" class="xovi_shortColumn" style="text-align:center;">&plusmn;</th>            
                            <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('URL','xovi');?></th>

                        </tr>
                    </tfoot>
                    <tbody id="the-list">
<?php

        foreach( $xovi_myDailyKeywords as $val) {

            echo sprintf('<tr class="xovi_monitoringRow">
                    <td scope="row" id="" class="" style=""><a href="%8$s&keyword=%1$s&sengineId=%4$s">%1$s</a></td>                                        
                    <td scope="row" style="text-align:right;">%5$s</td>
                    <td scope="row" style="text-align:left;">%7$s</td>
                    <td scope="row" id="" class="" style="">%2$s</td>        
                </tr>', 
                $val->keyword, ((!empty($val->url)) ? sprintf('<a href="http://%1$s" target="_blank">%1$s</a>', urldecode($val->url)) : " - "), $val->crawlDateTime, 
                $val->sengineId, $val->position, number_format($val->resultCount,0,",","."), 
                xovi_formatPositionChange(intval($val->positionChange)),                 
                admin_url("admin.php?page=XOVIWPSuite/xovi_monitoring.php", __FILE__)
            );
        }
?>
                    </tbody>
                </table>
            
<?php
        
    } else {
        echo xovi_createMessage(__('No keywords defined for this domain','xovi').'<br /><br /><a href="https://suite.xovi.net/keywords/monitor/add" target="_blank">'.__('Add keywords to monitore here!','xovi').'</a>','error');
    }
}
?>              
             
            </td>
        </tr>
    </tbody>    
</table>

