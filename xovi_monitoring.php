<div class="wrap">
    <h2><?php echo __('Keyword Monitoring','xovi').XOVI_PLUGINTITLE;?></h2>
<?php

if(empty($xovi_options["xovi[apitoken]"])) {
    echo xovi_createMessage('Kein API-Token hinterlegt!', 'error');
    return;
}

$xovi_currentFile = admin_url('admin.php?page='.$_GET['page']);

$sengineId = isset($_GET['sengineId']) ? $_GET['sengineId'] : "1"; 
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
$url = isset($_GET['url']) ? $_GET['url'] : "";

/* $limit = isset($_GET['limit']) ? $_GET['limit'] : "";
$sortcol = isset($_GET['orderby']) ? $_GET['orderby'] : "";
$sortdir = isset($_GET['order']) ? $_GET['order'] : ""; */

if(isset($_GET['keyword'])) {
    

    
    $xovi_dailyKeytrend = xovi_myDailyKeywordTrend($url, $keyword, $sengineId);
    
    if(!empty($xovi_dailyKeytrend)) {
      
$xovi_chartscript = <<<JAVASCRIPT
<script type="text/javascript">
    var chartdata = [];
        chartdata['pos'] = %1\$s;
        chartdata['rec'] = %2\$s;
   
    jQuery(document).ready(function() {     
        console.log(chartdata);
        createChart(chartdata['pos']);
        createChart(chartdata['rec']);
    });
</script>
JAVASCRIPT;

        $xovi_monitoringData = xovi_createDailyKeywordtrendChart($xovi_dailyKeytrend);
        echo sprintf($xovi_chartscript, json_encode($xovi_monitoringData['pos']), json_encode($xovi_monitoringData['rec']) );

?>  
<div class="xovichart" id="xovichart_monitoringPosition"></div>
<div class="xovichart" id="xovichart_monitoringResultcount"></div>
<?php   

    } else {
         echo xovi_createMessage(__('No data available for this Keyword!','xovi'),'error');
    }    
    echo xovi_createBackbutton(XOVI_CURRENT_PAGE);
    
    
} else {
    
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
            <th scope="col" id="" class="xovi_mediumColumn" style="text-align:right;"><?php echo __('Results','xovi');?></th>           
            <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('Refreshed','xovi');?></th>
            <th scope="col" id="" class="xovi_mediumColumn" style="text-align:center;"><?php echo __('Universal Search','xovi');?></th>            
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th scope="col" id="" class="xovi_mediumColumn"><?php echo __('Keyword','xovi');?></th>                                              
            <th scope="col" id="" class="xovi_shortColumn" style="text-align:right;"><?php echo __('Position','xovi');?></th>
            <th scope="col" id="" class="xovi_shortColumn" style="text-align:center;">&plusmn;</th>            
            <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('URL','xovi');?></th>
            <th scope="col" id="" class="xovi_mediumColumn" style="text-align:right;"><?php echo __('Results','xovi');?></th>
            <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('Refreshed','xovi');?></th>
            <th scope="col" id="" class="xovi_mediumColumn" style="text-align:center;"><?php echo __('Universal Search','xovi');?></th>
           
        </tr>
    </tfoot>
    <tbody id="the-list">
<?php

        foreach( $xovi_myDailyKeywords as $val) {
            
            echo sprintf('<tr class="xovi_monitoringRow">
                    <td scope="row" id="" class="" style=""><a href="%9$s&keyword=%1$s&sengineId=%4$s&url=%2$s">%1$s</a></td>                                        
                    <td scope="row" style="text-align:right;">%5$s</td>
                    <td scope="row" style="text-align:left;">%7$s</td>
                    <td scope="row" id="" class="" style=""><a href="http://%2$s" target="_blank">%2$s</a></td>
                    <td scope="row" style="text-align:right;">%6$s</td>
                    <td scope="row" id="" class="" style=""><em>%3$s</em></td>
                    <td scope="row" style="text-align:center;">%8$s</td>                
                </tr>', 
                $val->keyword, 
                $val->domain, $val->crawlDateTime, 
                $val->sengineId, $val->position, number_format($val->resultCount,0,",","."), 
                xovi_formatPositionChange(intval($val->positionChange)), 
                xovi_formatUSearch($val->universalSearch),
                XOVI_CURRENT_PAGE 
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
</div>