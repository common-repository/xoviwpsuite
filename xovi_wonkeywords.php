<div class="wrap">
<?php
if(empty($xovi_options["xovi[apitoken]"])) {
    echo "<h2>".__('Wonkeywords','xovi').XOVI_PLUGINTITLE."</h2>";    
    echo xovi_createMessage('Kein API-Token hinterlegt!', 'error');
    return;
}
$xovi_userSE = xovi_mySearchEngines($xovi_options["xovi[suma]"]);   // user defined search engines

//$sortcol = isset($_GET['orderby']) ? $_GET['orderby'] : "";
//$sortdir = isset($_GET['order']) ? $_GET['order'] : "";

$xovi_currentSE = isset($_GET['sengine']) ? $_GET['sengine'] : $xovi_userSE[0]; // show tab either by GET-param or First user selected search engine
$xovi_skip = isset($_GET['skip']) ? (integer)$_GET['skip'] : 0;

$xovi_keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;  


?>
<h2><?php echo __('Wonkeywords - Summary','xovi').XOVI_PLUGINTITLE;?> </h2>
<?php
        $xovi_tabmenu = "";
        foreach($xovi_userSE as $sengine) { 
            $xovi_tabmenu .= sprintf('<a href="%1$s&sengine=%3$s" class="nav-tab%2$s">%3$s</a>',XOVI_CURRENT_PAGE,($sengine == $xovi_currentSE) ? " nav-tab-active" : "" ,$sengine);
        }    
        $xovi_keywords = xovi_myWonKeywords($xovi_currentSE, $xovi_skip);   
        $xovi_skipnext = ((sizeof($xovi_keywords) < $xovi_options['xovi[hits]']) ? -1 : $xovi_skip); // check whether next page exitst and set 
        $xovi_paginationLink = sprintf('%1$s&sengine=%2$s', XOVI_CURRENT_PAGE, $xovi_currentSE);                 
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
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th scope="col" id="" class="" style=""><?php echo __('Keyword','xovi');?></th>
            <th scope="col" id="" class="" style="text-align:center;"><?php echo __('Position','xovi');?></th> 
        </tr>
    </tfoot>
    <tbody id="the-list">
<?php

if(empty($xovi_keywords)){
    echo '<tr>
            <td scope="col" id="" class="" style="">'.__('No keywords found!','xovi').'</td>
        </tr>';
}else{
    foreach( $xovi_keywords as $val) {

        echo sprintf('<tr>
            <td scope="col" id="" class="" style=""><a href="%3$s&keyword=%1$s&sengine=%4$s">%1$s</a></td>
            <td scope="col" id="" class="" style="text-align:center;">%2$s</td>
        </tr>', $val->keyword, $val->position, XOVI_CURRENT_PAGE, $xovi_currentSE);        
    }    
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

</div>