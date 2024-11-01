<div class="wrap">
<?php
if(empty($xovi_options["xovi[apitoken]"])) {
    echo "<h2>".__('Rankingvalue','xovi').XOVI_PLUGINTITLE."</h2>";    
    echo xovi_createMessage('Kein API-Token hinterlegt!', 'error');
    return;
}
$xovi_userSE = xovi_mySearchEngines($xovi_options["xovi[suma]"]);   // user defined search engines
$xovi_currentSE = isset($_GET['sengine']) ? $_GET['sengine'] : $xovi_userSE[0]; // show tab either by GET-param or First user selected search engine


?>
<h2><?php echo __('Rankingvalue','xovi').XOVI_PLUGINTITLE;?> </h2>
<?php
        $xovi_tabmenu = "";
        foreach($xovi_userSE as $sengine) { 
            $xovi_tabmenu .= sprintf('<a href="%1$s&sengine=%3$s" class="nav-tab%2$s">%3$s</a>',XOVI_CURRENT_PAGE,($sengine == $xovi_currentSE) ? " nav-tab-active" : "" ,$sengine);
        }    
        $xovi_rankingvalue = xovi_myRankingvalue($xovi_currentSE);  

    if(!empty($xovi_rankingvalue)) {   

?>
 
     <h2 class="nav-tab-wrapper">
<?php echo $xovi_tabmenu;?>
    </h2>

<?php


    echo sprintf('<div id="xovi_rankingvalue"> 
                       <p style="text-align:center; font-size:35px"><strong>%1$s%2$s</strong></p>
                    </div>',number_format($xovi_rankingvalue->rankingValue,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP), xovi_currency($xovi_currentSE)) ;

?>        


<?php
    } else {
        echo xovi_createMessage(__('No Rankingvalue found!','xovi'), 'error');
    }

?>
</div>