<?php

/**
 * xovi_exceptionHandle
 * 
 * catches all uncaught exceptions and creates error message.
 * 
 * @param string $info json Encoded api-result
 */
function xovi_exceptionHandle($info) {    
    
    $apiMessage = json_decode($info);
    
    echo xovi_createMessage(__("Not enough Credits!"), 'error');
}
set_exception_handler('xovi_exceptionHandle');





/**
 * xovi_createBackbutton()
 * 
 * creates a link to given Link (normally summary)
 * 
 * @param string $link
 * @return string
 */
function xovi_createBackbutton($link) {    
    return sprintf('<a href="%1$s">%2$s</a>', $link, __('&lArr; back to summary','xovi'));
}

function xovi_createPagebutton($type, $skip, $link) {

    $titleArr = array(
        "prev" => __('Previous Records'),
        "next" => __('Next Records')
    );
    $title   = $titleArr[$type];
    $label   = ($type == 'prev') ? '« '.$title : $title.' »';                
    $toLimit = ($type == 'prev') ? ($skip - 1) : $skip + 1 ;

    $xovi_prevDisabled = (($skip == 0) ? true : false);
    $xovi_nextDisabled = (($skip == -1)) ? true : false;
 
    $isDisabled = (($type == 'prev') ? $xovi_prevDisabled : $xovi_nextDisabled);
    
        $className = (!$isDisabled) ? '' : " disabled";
        $link .= (!$isDisabled) ? sprintf('&skip=%1$s', $toLimit) : "#";
    
    return sprintf('<a class="%1$s-page%2$s" title="%4$s" href="%3$s">%5$s</a>', $type, $className, $link, $title, $label);

} 

/**
 * xovi_createMessage()
 * 
 * creates a message in common Wordpress style
 * 
 * @param string $message 
 * @param string $type [_update_|error]
 * @return string
 */        
function xovi_createMessage($message, $type = 'update') {

    if($type != 'update') {
        $className = 'error settings-error';
    } else {
        $className = 'updated settings-error';
    }

    return sprintf('<div id="setting-error-settings_updated" class="%1$s"> 
                       <p style="text-align:center"><strong>%2$s</strong></p>
                    </div><br /><br />', $className,$message);
}


/**
 * xovi_isSumaChecked()
 * 
 * Checks a bitmask, whether a checkbox has to be checked
 * and returns the html-attribute.
 * 
 * @param int $var Alle Bits
 * @param int $val Bits die geprüft werden
 * @return string 
 */
function xovi_isSumaChecked($var, $val) {
    return ($var & $val ) != 0 ? 'checked="checked"' : '';
}

/**
 * xovi_isSumaChecked()
 * 
 * Checks a bitmask, whether a checkbox has to be checked
 * and returns the html-attribute.
 * 
 * @param int $var Alle Bits
 * @param int $val Bits die geprüft werden
 * @return string 
 */
function xovi_isWidgetChecked($var, $val) {
    return ($var & $val ) != 0 ? 'checked="checked"' : '';
}

/**
 * Checks a bitmask, to get searchengine names.
 * 
 * @param integer $val
 * @return array
 */
function xovi_mySearchEngines($val) {
        
    $SE = array();
    
    if(($val & 1)!=0)$SE[] = "google.de";
    if(($val & 2)!=0)$SE[] = "google.at";
    if(($val & 4)!=0)$SE[] = "google.ch";
    if(($val & 8)!=0)$SE[] = "bing.com";
    if(($val & 16)!=0)$SE[] = "google.com";
    if(($val & 32)!=0)$SE[] = "google.co.uk";
    if(($val & 64)!=0)$SE[] = "google.fr";
    if(($val & 128)!=0)$SE[] = "google.es";
    if(($val & 256)!=0)$SE[] = "google.it";
        
    return $SE;
    
}

/**
 * Checks a bitmask, to get dashboard widget names.
 * 
 * @param integer $val
 * @return array
 */
function xovi_myDashboardTools($val) {
        
    $tools = array();
    if(($val & 1)!=0)$tools[] = "Credits";
    if(($val & 2)!=0)$tools[] = "Keyword Monitoring";
    if(($val & 4)!=0)$tools[] = "SEO Trends";
    
    return $tools;
    
}
/**
 * xovi_shorten()
 * 
 * Shorten a string to parsed length.
 * Adds a postfix, when string was shortened
 * 
 * @param string $string
 * @param integer $maxlength
 * @param string $postfix
 * @return string
 */
 function xovi_shorten($string, $maxlength = 100, $postfix = "&hellip;") {     
     return (strlen($string) > $maxlength) ? substr($string, 0, $maxlength).$postfix : $string;
 }
 
 /**
  * Creates a TagCloud, based on parsed density-array 
  * 
  * @param array $density return value from XOVI-API
  * @return string
  */
 function xovi_densityCloud($density) {
     $res = "";
     $sizes = array();
     foreach($density as $keyword => $val) {
         
         $fontsize = round($val * 1000 * 2);
         
         if($fontsize > 32) $fontsize = 32;
         if($fontsize < 8) $fontsize = 8;
         
         $sizes[] = $fontsize;
         $res .= sprintf('<span class="keyword" style="font-size:%2$spx">%1$s</span>', $keyword, $fontsize)."&emsp;";         
     }     
     return sprintf('<div class="xovi_backlinkCloud" style="line-height:%1$spx">%2$s</div>',max($sizes), $res);     
 }

/**
 * xovi_formatDate()
 * 
 * formats a datestring to an other format.
 * the blog's language is the indicator for this translation.
 * 
 * @param type $date 
 * @return string
 */
function xovi_formatDate($date) {        
    switch(get_bloginfo('language')) {        
        case 'de-DE': return date("d.m.Y", strtotime($date));
        default: return $date;        
    }
}

/**
 * xovi_formatPositionChange()
 * 
 * formats the current Position 
 * and adds an arrow to show differences.
 * 
 * @param int $position
 */
function xovi_formatPositionChange($position) {
        
    $change = $color = '';
    if($position > 0) {
        $color = "green";
        $change = " up";        
    } elseif($position < 0) {
        $change = " down";
        $color = "red";        
    } 
    
    return sprintf('<span class="xovi_positionArrow%1$s"></span>&emsp;<span style="color:%3$s">(%2$s)</span>', $change, strval($position), $color);
    
    
}

/**
 * xovi_formatUSearch() 
 * 
 * Formats an Universal search result
 * 
 * @param string $usearch
 */
function xovi_formatUSearch($usearch) {    
    if(strlen($usearch) > 0) {
        return __($usearch,'xovi_lang');
    } else return " - ";    
}

/**
 * 
 * xovi_weekNum()
 * 
 * returns week number of parsed date.
 * 
 * @param string $date
 * @return string
 */
function xovi_weekNum($date) {     
    return sprintf('<small>%1$s</small><b>%2$s</b>',__("Week Number: "),date('W',strtotime($date)));
}

function xovi_currency($searchengine){
    
    switch($searchengine){
    case 'google.ch':
        $currency_symbol = '₣';
        break;
    case 'google.com':
        $currency_symbol = '$';
        break;
    case 'google.co.uk':
        $currency_symbol = '£';
        break;
    case 'google.es':
    case 'google.fr':
    case 'google.at':
    case 'google.de':
    case 'bing.com (de)':
    default:
        $currency_symbol = '€';
    }
    
    return $currency_symbol;
}
?>
