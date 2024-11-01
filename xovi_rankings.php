<div class="wrap">
<?php
if(empty($xovi_options["xovi[apitoken]"])) {
    echo "<h2>".__('Rankings','xovi').XOVI_PLUGINTITLE."</h2>";    
    echo xovi_createMessage('Kein API-Token hinterlegt!', 'error');
    return;
}
$xovi_userSE = xovi_mySearchEngines($xovi_options["xovi[suma]"]);   // user defined search engines

//$sortcol = isset($_GET['orderby']) ? $_GET['orderby'] : "";
//$sortdir = isset($_GET['order']) ? $_GET['order'] : "";

$xovi_currentSE = isset($_GET['sengine']) ? $_GET['sengine'] : $xovi_userSE[0]; // show tab either by GET-param or First user selected search engine
$xovi_skip = isset($_GET['skip']) ? (integer)$_GET['skip'] : 0;

$xovi_keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;  



if(isset($xovi_keyword)) {
    
    $xovi_keytrendData = xovi_createKeywordtrendChart($xovi_keyword);
    
    if(!empty($xovi_keytrendData)) {
      
$xovi_chartscript = <<<JAVASCRIPT
<script type="text/javascript">
    var chartData = %1\$s;
   
    jQuery(document).ready(function() {     
        console.log(chartData);
        createChart(chartData);        
    });
</script>
JAVASCRIPT;

        echo sprintf($xovi_chartscript, json_encode($xovi_keytrendData));
?>
<h2><?php echo __('Rankings','xovi').XOVI_PLUGINTITLE;?> </h2>
<div class="xovichart" id="xovichart_keywordTrend"></div>
<?php

    } else echo xovi_createMessage(__('No data available for this Keyword!','xovi'), 'error');   
    
    echo xovi_createBackbutton(XOVI_CURRENT_PAGE."&sengine=".$xovi_currentSE);
    
} else {
?>
<h2><?php echo __('Rankings - Summary','xovi').XOVI_PLUGINTITLE;?> </h2>
<?php
        $xovi_tabmenu = "";
        foreach($xovi_userSE as $sengine) { 
            $xovi_tabmenu .= sprintf('<a href="%1$s&sengine=%3$s" class="nav-tab%2$s">%3$s</a>',XOVI_CURRENT_PAGE,($sengine == $xovi_currentSE) ? " nav-tab-active" : "" ,$sengine);
        }    
        $xovi_keywords = xovi_myKeywords($xovi_currentSE, $xovi_skip);        
        $xovi_skipnext = ((sizeof($xovi_keywords) < $xovi_options['xovi[hits]']) ? -1 : $xovi_skip); // check whether next page exitst and set 
        $xovi_paginationLink = sprintf('%1$s&sengine=%2$s', XOVI_CURRENT_PAGE, $xovi_currentSE);                 
        
    if(!empty($xovi_keywords)) {   
        
?>
 
     <h2 class="nav-tab-wrapper">
<?php echo $xovi_tabmenu;?>
    </h2>
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
            <th scope="col" id="" class="" style=""><?php echo __('Keyword','xovi');?></th>
            <th scope="col" id="" class="xovi_shortColumn" style="text-align:center;"><?php echo __('Position','xovi');?></th>
            <th scope="col" id="" class="" style=""><?php echo __('URL','xovi');?></th>          
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th scope="col" id="" class="" style=""><?php echo __('Keyword','xovi');?></th>
            <th scope="col" id="" class="" style="text-align:center;"><?php echo __('Position','xovi');?></th> 
            <th scope="col" id="" class="" style=""><?php echo __('URL','xovi');?></th>            
        </tr>
    </tfoot>
    <tbody id="the-list">
<?php
        foreach( $xovi_keywords as $val) {
            
            echo sprintf('<tr>
                <td scope="col" id="" class="" style=""><a href="%4$s&keyword=%1$s&sengine=%5$s">%1$s</a></td>
                <td scope="col" id="" class="" style="text-align:center;">%2$s</td>
                <td scope="col" id="" class="" style=""><a href="%3$s" target="_blank">%3$s</a></td>                    
            </tr>', $val->keyword, $val->position, urldecode($val->url), XOVI_CURRENT_PAGE, $xovi_currentSE);        
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
    } else {
        echo xovi_createMessage(__('No rankings found!','xovi'), 'error');
    }
    
}
?>
</div>