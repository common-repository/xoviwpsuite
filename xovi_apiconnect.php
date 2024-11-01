<?php
/**
 * xovi_build_query()
 * 
 * Creates the querystring for the xovi-api.
 * 
 * @param array $args
 * @return string
 */
function xovi_build_query($args) {
    
    $urlPattern = join("/", $args);
    
    return 'https://suite.xovi.net/api/'.$urlPattern;
}


/**
 * xovi_apiConnect()
 * 
 * Connects to xovi-api using cURL.
 * 
 * @param array $args - Arguments for the query
 * @return type
 */
function xovi_apiConnect($args) {
 
    if(empty($args['key'])) {
        return array();
    }
    
    try {        
            if (!function_exists('curl_init')) {
                echo __('cURL is not available', 'xovi');
            } else {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                // needed for SSL
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);                // needed for SSL
                curl_setopt($ch, CURLOPT_URL, xovi_build_query($args));     // form and set URL
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);             // parse data

                $output = curl_exec($ch);                                   // download the given URL
                curl_close($ch);                                            // close connection to free space
            }

            $tmp = json_decode($output, false);

            if($tmp->apiErrorCode == 0 && $tmp->apiErrorMessage == '0k.') {        
                $tmp = $tmp->apiResult;
            } else/*if( $tmp->apiErrorMessage == 'result empty') {*/
                $tmp = array();  
            /*} else {     
                switch($tmp->apiErrorMessage) {        
                    case "cost error": 
                        throw new XOVIApi_CreditException('not enough credits',1);
                      break;          
                    case 'internal error':              
                        throw new XOVIApi_ErrorException($output, $tmp->apiErrorCode);
                      break;
                    case 'param missing':
                    case 'param invalid': 
                        throw new XOVIApi_ErrorException($output, $tmp->apiErrorCode);
                      break;
                    default:
                        throw new XOVIApi_Exception($tmp->apiErrorMessage, $tmp->apiErrorCode);
                      break;
                }
            }*/
            
        }
        catch(Exception $ex) {
            echo $ex->getMessage();
        }
        
        
    return $tmp;
}

/**
 * xovi_myCredits()
 * 
 * Prepares and Executes a query 
 * to read the actual amount of credits. 
 * 
 * @return object 
 */
function xovi_myCredits() {
    
    $xovi_options = get_option('xovi_options_vars');
    
    return xovi_apiConnect(array(        
        'service' => 'user',
        'method'  => 'getCreditstate',
        'key'     => $xovi_options['xovi[apitoken]'],
        'format'  => 'json',
    ));
}

/**
 * xovi_myOviTrend()
 * 
 * Prepares and Executes a query 
 * to get the OVI-trend
 * 
 * @return object
 */
function xovi_myOviTrend($sengine) {
    $xovi_options = get_option('xovi_options_vars');
        
    return xovi_apiConnect(array(
       
       'service' => 'keywords',
       'method'  => 'getOviTrend',
       'key'     => $xovi_options['xovi[apitoken]'],
       'domain'  => $xovi_options['xovi[domain]'],
       'sengine' => $sengine,       
       'format'  => 'json',
       'limit'   => $xovi_options['xovi[weeks]']
    ));              
}

/**
 * xovi_myStaticOviTrend()
 * 
 * Prepares and Executes a query 
 * to get the static OVI-trend
 * 
 * @return object
 */
function xovi_myStaticOviTrend($sengine) {
    $xovi_options = get_option('xovi_options_vars');
        
    return xovi_apiConnect(array(
       
       'service' => 'keywords',
       'method'  => 'getStaticOviTrend',
       'key'     => $xovi_options['xovi[apitoken]'],
       'domain'  => $xovi_options['xovi[domain]'],
       'sengine' => $sengine,       
       'format'  => 'json',
       'limit'   => $xovi_options['xovi[weeks]']
    ));              
}

/**
 * xovi_myDomainTrend()
 * 
 * Prepares and Executes a query 
 * to get the Domain-trend
 * 
 * @return object
 */
function xovi_myDomainTrend() {
    $xovi_options = get_option('xovi_options_vars');

    return xovi_apiConnect(array(
        'service' => 'links',
        'method'  => 'getDomainTrend',        
        'key'     => $xovi_options['xovi[apitoken]'],
        'domain'  => $xovi_options['xovi[domain]'],
        'format'  => 'json',
        'limit'   => $xovi_options['xovi[weeks]']
    ));
}


/**
 * xovi_myDomainTrend()
 * 
 * Prepares and Executes a query 
 * to get the Domain-trend
 * 
 * @return object
 */
function xovi_mySocialSignals() {
    $xovi_options = get_option('xovi_options_vars');

    return xovi_apiConnect(array(
        'service' => 'socialSignals',
        'method'  => 'getNetworkInfo',        
        'key'     => $xovi_options['xovi[apitoken]'],
        'domain'  => $xovi_options['xovi[domain]'],
        'format'  => 'json',
    ));
}

/**
 * xovi_myKeywords
 * 
 * Prepares and Executes a query 
 * to get the Keywords
 * 
 * @return object
 */
function xovi_myKeywords($searchEngine, $skip = 0) {
    
    $xovi_options = get_option('xovi_options_vars');           
    
    return xovi_apiConnect(array(
        'service' => 'keywords',
        'method'  => 'getKeywords',
        'key'     => $xovi_options["xovi[apitoken]"],            
        'domain'  => $xovi_options["xovi[domain]"],
        'sengine' => $searchEngine,
        'format'  => 'json',
        'limit'   => $xovi_options["xovi[hits]"],
        'skip'    => $skip,
    ));                   
}

/**
 * xovi_myLostKeywords
 * 
 * Prepares and Executes a query 
 * to get the Lost Keywords
 * 
 * @return object
 */
function xovi_myLostKeywords($searchEngine, $skip = 0) {
    
    $xovi_options = get_option('xovi_options_vars');           
    
    return xovi_apiConnect(array(
        'service'     => 'keywords',
        'method'      => 'getLostKeywords',
        'key'         => $xovi_options["xovi[apitoken]"],            
        'urlpattern'  => $xovi_options["xovi[domain]"],
        'sengine'     => $searchEngine,
        'format'      => 'json',
        'limit'       => $xovi_options["xovi[hits]"],
        'skip'        => $skip,
    ));                   
}

/**
 * xovi_myWonKeywords
 * 
 * Prepares and Executes a query 
 * to get the Won Keywords
 * 
 * @return object
 */
function xovi_myWonKeywords($searchEngine, $skip = 0) {
    
    $xovi_options = get_option('xovi_options_vars');           
    
    return xovi_apiConnect(array(
        'service'     => 'keywords',
        'method'      => 'getNewKeywords',
        'key'         => $xovi_options["xovi[apitoken]"],            
        'urlpattern'  => $xovi_options["xovi[domain]"],
        'sengine'     => $searchEngine,
        'format'      => 'json',
        'limit'       => $xovi_options["xovi[hits]"],
        'skip'        => $skip,
    ));                   
}

/**
 * xovi_myPages
 * 
 * Prepares and Executes a query 
 * to get the pages
 * 
 * @return object
 */
function xovi_myPages($searchEngine, $skip = 0) {
    
    $xovi_options = get_option('xovi_options_vars');           
    
    return xovi_apiConnect(array(
        'service'     => 'keywords',
        'method'      => 'getPages',
        'key'         => $xovi_options["xovi[apitoken]"],            
        'urlpattern'  => $xovi_options["xovi[domain]"],
        'sengine'     => $searchEngine,
        'format'      => 'json',
        'limit'       => $xovi_options["xovi[hits]"],
        'skip'        => $skip,
    ));                   
}

/**
 * xovi_myRankingvalue
 * 
 * Prepares and Executes a query 
 * to get the rankingvalue
 * 
 * @return object
 */
function xovi_myRankingvalue($searchEngine) {
    
    $xovi_options = get_option('xovi_options_vars');           
    
    return xovi_apiConnect(array(
        'service'     => 'keywords',
        'method'      => 'getRankingValue',
        'key'         => $xovi_options["xovi[apitoken]"],            
        'urlpattern'  => $xovi_options["xovi[domain]"],
        'sengine'     => $searchEngine,
        'format'      => 'json',
    ));                   
}

/**
 * xovi_myKeywords
 * 
 * Prepares and Executes a query 
 * to get the Trend for the passed keyword
 * 
 * @param string $keyword Keyword
 * @return object
 */
function xovi_myKeywordTrend($keyword, $sengine) {
 
    $xovi_options = get_option('xovi_options_vars'); 
             
    return xovi_apiConnect(array(
        'service' => 'keywords',
        'method'  => 'getKeywordTrend',        
        'key'     => $xovi_options["xovi[apitoken]"],
        'domain'  => $xovi_options["xovi[domain]"],                  
        'keyword' => $keyword,
        'sengine' => $sengine,
        'format'  => 'json',
        'limit'   => $xovi_options["xovi[weeks]"],
    ));
     
}

/**
 * xovi_myDailyKeywords()
 * 
 * Prepares and Executes a query 
 * to get all Daily Keywords
 * 
 * @global type $xovi_options
 * @return object
 */
function xovi_myDailyKeywords() {

    $xovi_options = get_option('xovi_options_vars');
 
    #return xovi_apiConnect(array(
    return xovi_apiConnect(array(
        'service'   => 'keywords',
	'method'    => 'getDailyKeywords',
        'key'       => $xovi_options["xovi[apitoken]"],        
	'format'    => 'json',
        'limit'     => 'NULL',
        'skip'      => 'NULL',
        'keyword'   => 'NULL',
        //'domain'    => str_replace("www.", "", $xovi_options["xovi[domain]"]),
    ));    
}

/**
 * xovi_myDailyKeywordTrend()
 * 
 * Prepares and Executes a query 
 * to get the DailyTrend for the passed keyword
 * 
 * @param int $sengineId ID of the Search Engine
 * @param sting $keyword Keyword
 * @return object
 */
function xovi_myDailyKeywordTrend($url, $keyword, $sengineId) {
    
    $xovi_options = get_option('xovi_options_vars');    
    
    return xovi_apiConnect(array(
	'service'       => 'keywords',
        'method'	=> 'getDailyKeywordTrend',                
        'key'           => $xovi_options["xovi[apitoken]"],            
        'sengineId'	=> $sengineId,
        'domain'        => $url, //$xovi_options["xovi[domain]"],
	'keyword'	=> $keyword,        
	'format'	=> 'json',
        'limit'         => $xovi_options['xovi[weeks]']
    )); 
    
}

/**
 * 
 * xovi_myBacklinks()
 * 
 * gets 100 Backlinks of given domain.
 * 
 * @return object
 */
function xovi_myBacklinks($skip = 0) {
    
     $xovi_options = get_option('xovi_options_vars');
    
     return xovi_apiConnect(array(  
        'service' => 'links',
        'method'  => 'getBacklinks',
        'key'     => $xovi_options["xovi[apitoken]"],   
        'domain'  => $xovi_options["xovi[domain]"],   
        'format'  => 'json',
        'limit'   => $xovi_options["xovi[hits]"],
        'skip'    => $skip
    ));
}

/**
 * 
 * xovi_myReportings() 
 * 
 * Get's all Reports considered with given domain
 * 
 * @return object
 */
function xovi_myReportings() {
     
     $xovi_options = get_option('xovi_options_vars');
     
     return xovi_apiConnect(array(  
        'service' => 'report',
        'method'  => 'getDownloads',
        'key'     => $xovi_options["xovi[apitoken]"],          
        'format'  => 'json',
    ));   
}

class XOVIApi_Exception extends Exception {}
class XOVIApi_ErrorException extends Exception {}
class XOVIApi_CreditException extends Exception {}



/*
function xovi_myReport($reportId, $format) {
        
    $xovi_options = get_option('xovi_options_vars');
    
     return xovi_apiConnect(array(  
        'key'     => $xovi_options["xovi[apitoken]"],      
        'service' => 'report',
        'method'  => 'getpdf',
        'id'  => $reportId,
        'format'  => $format,
    ));
     
}

function xovi_getSearchEngines($interval) {
    
    $xovi_options = get_option('xovi_options_vars');
    
    $res = xovi_apiConnect(array(
	'key'       => $xovi_options['xovi[apitoken]'],
	'service' =>'seo',
        'method' =>'getsearchengines',
        'interval' => $interval,
        'format' => 'json',
    ));
    if($res->apiErrorCode == 0 && $res->apiErrorMessage == '0k.' && !empty($res->apiResult)) {
        return $res->apiResult;
    } 
}

function xovi_getSearchEnginesByName($interval) {
    
    $_searchEngines = array();
    $searchEngines = xovi_getSearchEngines($interval);
        
    foreach($searchEngines as $searchEngine) {
        $_searchEngines[$searchEngine['name']] = $searchEngine['id'];
    }            
}

  
function xovi_myMonitoringDomains() {
    $xovi_options = get_option('xovi_options_vars');
    
    $res = xovi_apiConnect(array(
	'key'     => $xovi_options["xovi[apitoken]"], 
	'service' => 'seo',
	'method'  => 'getDailyDomains',
	'format'  => 'json',
    ));
    
    if($res->apiErrorCode == 0 && $res->apiErrorMessage == '0k.' && !empty($res->apiResult)) {
        return $res->apiResult;
    }
    
}
*/


?>
