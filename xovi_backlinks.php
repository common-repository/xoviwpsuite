<div class="wrap">
    <h2><?php echo __('Backlinks','xovi').XOVI_PLUGINTITLE;?></h2>
<?php

if(empty($xovi_options["xovi[apitoken]"])) {
    echo xovi_createMessage('Kein API-Token hinterlegt!', 'error');
    return;
}

    $xovi_skip = isset($_GET['skip']) ? (integer)$_GET['skip'] : 0;                 // get Pagenumber by api-skip
    $xovi_myBacklinks = xovi_myBacklinks($xovi_skip);                               // get Results from api
    $xovi_skipnext = ((sizeof($xovi_myBacklinks) < $xovi_options['xovi[hits]']) ? -1 : $xovi_skip); // check whether next page exitst and set 
    $xovi_paginationLink = sprintf('%1$s', XOVI_CURRENT_PAGE);                                  // set Link for pagination
 
    if(!empty($xovi_myBacklinks)) {
        
?>

    <div class="tablenav top">
        <div class="tablenav-pages">
            <span class="pagination-links">
<?php

    echo xovi_createPagebutton("prev", $xovi_skip, $xovi_paginationLink);
    echo xovi_createPagebutton("next", $xovi_skipnext, $xovi_paginationLink);
    
?>
            </span>
        </div>
    </div>
    <table class="wp-list-table widefat fixed" cellspacing="0">
        <thead>
            <tr>            
                <th scope="col" id="" class="xovi_mediumColumn"><?php echo __('Backlink','xovi');?>            
                <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('Anchor','xovi');?></th>
                <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('Website Title','xovi');?></th>
                <th scope="col" id="" class="xovi_shortColumn" style="text-align:left;"><?php echo __('Links','xovi');?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th scope="col" id="" class="xovi_mediumColumn"><?php echo __('Backlink','xovi');?>            
                <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('Anchor','xovi');?></th>
                <th scope="col" id="" class="xovi_mediumColumn" style="text-align:left;"><?php echo __('Website Title','xovi');?></th>
                <th scope="col" id="" class="xovi_shortColumn" style="text-align:left;"><?php echo __('Links','xovi');?></th>
            </tr>
        </tfoot>
        <tbody id="the-list">
<?php

    foreach($xovi_myBacklinks as $val) {
     
        echo sprintf('<tr class="xovi_monitoringRow">               
                         <td scope="row" style="text-align:left;"><a href="%1$s" target="_blank">%2$s</a><br /><br />&rArr;&emsp;<a href="%3$s" target="_blank">%4$s</a><br /></td>
                         <td scope="row" style="text-align:left;">%5$s</td>               
                         <td scope="row" id="" class="" style="">%6$s</td>
                         <td scope="row" id="" class="" style="">%7$s</td>                    
                      </tr>',
                      urldecode($val->linkingUrl), trim(xovi_shorten($val->linkingUrl, 55)), 
                      urldecode($val->linkedUrl), xovi_shorten($val->linkedUrl, 50), 
                      !empty($val->anchor) ? $val->anchor : "<em>(n/a)</em>", 
                      $val->webtitle, sprintf('<div style="font-family:monospace">int: %1$s<br />ext: %2$s</div>', $val->linksIntern, $val->linksExtern)                
       );
   }  
   
?>
        </tbody>
    </table>
    <div class="tablenav bottom">
        <div class="tablenav-pages">
            <span class="pagination-links">
<?php

    echo xovi_createPagebutton("prev", $xovi_skip, $xovi_paginationLink);
    echo xovi_createPagebutton("next", $xovi_skipnext, $xovi_paginationLink);

?>
            </span>
        </div>
    </div>
<?php
} else echo xovi_createMessage(__('This Domain has no backlinks!','xovi'), 'error');

?>
</div>