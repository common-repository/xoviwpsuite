<div class="wrap">    
    <h2><?php echo __("SEO Trends",'xovi').XOVI_PLUGINTITLE;?></h2>
<?php
if(empty($xovi_options["xovi[apitoken]"])) {
    echo xovi_createMessage('Kein API-Token hinterlegt!', 'error');
    return;
}
$xovi_chartscript = <<<JAVASCRIPT
<script type="text/javascript">
    var chartData = [];
        chartData['ovi'] = %1\$s;
        chartData['dom'] = %2\$s;
        chartData['sta'] = %3\$s;
   
    jQuery(document).ready(function() {     
        console.log(chartData);

        createChart(chartData['ovi']);
        createChart(chartData['dom']);
        createChart(chartData['sta']);
    });
</script>
JAVASCRIPT;


$xovi_oviChart       = xovi_createOvitrendChart();
$xovi_domChart       = xovi_createDomaintrendChart();
$xovi_staticOviChart = xovi_createStaticOvitrendChart();

if(!empty($xovi_oviChart) && !empty($xovi_domChart) && !empty($xovi_staticOviChart)) {
    
    echo sprintf($xovi_chartscript,  $xovi_oviChart, $xovi_domChart, $xovi_staticOviChart);
    echo '<div class="xovichart" id="xovichart_ovitrend"></div><br /><div class="xovichart" id="xovichart_domaintrend"></div><br /><div class="xovichart" id="xovichart_staticovitrend"></div>';
    
} else {
    echo xovi_createMessage(__('No Data available!','xovi'), 'error');    
}
?>
</div>