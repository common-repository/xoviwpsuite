<div class="wrap">
    <h2><?php echo __('Reportings','xovi').XOVI_PLUGINTITLE;?></h2>
<?php
 
$xovi_currentFile = admin_url('admin.php?page='.$_GET['page']);
$xovi_myReportings = xovi_myReportings();
 
if(empty($xovi_options["xovi[apitoken]"])) {
    echo xovi_createMessage('Kein API-Token hinterlegt!', 'error');
    return;
}

if(!empty($xovi_myReportings)) {
        
    
?>
    <table class="wp-list-table widefat fixed" cellspacing="0">
        <thead>
            <tr>            
                <th scope="col" id="" class="xovi_shortColumn">&emsp;</th>
                <th scope="col" id="" class="xovi_mediumColumn"><?php echo __('Report');?></th>
                <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('Data basis', 'xovi');?></th>
                
                <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('Search Engine', 'xovi');?></th>                        
                

            </tr>
        </thead>
        <tfoot>
            <tr>

            </tr>
        </tfoot>
        <tbody id="the-list">
<?php
    foreach($xovi_myReportings as $val) {
        $currentLink = sprintf('https://suite.xovi.net/api/report/getPdf/%1$s/%2$s/pdf',$xovi_options['xovi[apitoken]'], $val->id);
        echo sprintf('<tr class="xovi_reportingsRow">               
                         <td scope="row" style="text-align:left;"><small>#%1$s</small></td>
                         <td><span style="font-size:16px">%8$s <a href="%7$s">%2$s</a></span></td>
                         <td scope="row" style="text-align:left;">%4$s / <em>%3$s</em></td>               
                         
                         <td scope="row" id="" class="" style="">%6$s</td>
                         
                      </tr>', 
                      $val->id, $val->domain, xovi_formatDate($val->reportDate), xovi_weekNum($val->reportDate), $val->finished, $val->sengine, $currentLink,
                      sprintf('<a class="xovi_getReport" href="%1$s" title="%2$s">&emsp;</a>', $currentLink, __('Download Report')));
   }    
?>
    </tbody>
</table>

<?php
} else {      
    echo xovi_createMessage(__('There are no reports created, yet!','xovi')."<br /><br />".sprintf('<a href="https://suite.xovi.net/reporting" target="_blank">%1$s</a>',__('Click Here to create a Report!','xovi')), 'error');                
}

?>
</div>