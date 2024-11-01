<?php 
function xovi_createStaticOvitrendChart() {
    
    global $xovi_options;
    
    $xovi_ovidata = array();
    
    foreach(xovi_mySearchEngines($xovi_options["xovi[suma]"]) as $sEngine) {     
        $xovi_ovidata[$sEngine] = xovi_myStaticOviTrend($sEngine);
    }
    
    
    if(!empty($xovi_ovidata)) {
    
                
        $currentSengineNum = 0;
        foreach($xovi_ovidata as $sengine => $ovidata) {        
            
            foreach($ovidata as $num => $vals) {
                $xovi_data['data'][$currentSengineNum][$num] = array($vals->date, $vals->staticOvi);
            }  
                        
            $xovi_data['series'][$currentSengineNum]['label'] = $sengine;
            //$xovi_data['data'][$currentSengineNum] = array_reverse($xovi_data[$currentSengineNum]['data']);
            
            $currentSengineNum++;
        }

        return json_encode(array(
            "container" => "xovichart_staticovitrend",            
            "isPositionchart" => false,
            "title" => "Static OVI Trend",
            "series" => $xovi_data['series'],
            "data" => $xovi_data['data']
        ));
    } else return false;
    
}

function xovi_createOvitrendChart() {
    
    global $xovi_options;
    
    $xovi_ovidata = array();
    
    foreach(xovi_mySearchEngines($xovi_options["xovi[suma]"]) as $sEngine) {     
        $xovi_ovidata[$sEngine] = xovi_myOviTrend($sEngine);
    }
    
    if(!empty($xovi_ovidata)) {
    
                
        $currentSengineNum = 0;
        foreach($xovi_ovidata as $sengine => $ovidata) {        
            
            foreach($ovidata as $num => $vals) {
                
                $xovi_data['data'][$currentSengineNum][$num] = array($vals->date, $vals->ovi);
            }  
                        
            $xovi_data['series'][$currentSengineNum]['label'] = $sengine;
            //$xovi_data['data'][$currentSengineNum] = array_reverse($xovi_data[$currentSengineNum]['data']);
            
            $currentSengineNum++;
        }

        return json_encode(array(
            "container" => "xovichart_ovitrend",            
            "isPositionchart" => false,
            "title" => "OVI Trend",
            "series" => $xovi_data['series'],
            "data" => $xovi_data['data']
        ));
    } else return false;
    
}


function xovi_createDomaintrendChart() {
    
    $xovi_domaintrend = xovi_myDomainTrend();    
  
    if(!empty($xovi_domaintrend)) {
        
        foreach($xovi_domaintrend as $num => $trenddata) {    
            foreach($trenddata as $key => $val) {
                $_xovi_data[$key][$num] = $val;                
            }        
        }
                
        $_dates = array_shift($_xovi_data);  
        $_labels = array_keys($_xovi_data);
        
        foreach($_labels as $num => $label) {
            $xovi_data['labels'][$num] = array(
                "label" => str_replace(array("domainPop","webpagePOP","backlinkPOP","hostPop","ipPop","classCPop","asnPop"),
                                       array("Domain POP","Webpage POP","Backlink POP","Host POP","IP POP","Class C POP","ASN POP"), 
                                       $label)
            );
        }
        
        $i = 0;
        foreach($_xovi_data as $key => $data) { 
            
            foreach($data as $num => $val) {
                $xovi_data['data'][$i][$num] = array($_dates[$num], $val);
            }
            $i++;
        }  
        
                
        return json_encode(array(
            "container" => "xovichart_domaintrend",            
            "isPositionchart" => false,
            #"type" => "line",
            "title" => "Domain Trend",            
            #"categories" => array_reverse($xovi_categories),             
            "series" => $xovi_data['labels'],
            "data" => $xovi_data['data']
        ));  
    } else {
        return false;        
    }
}

function xovi_createDailyKeywordtrendChart($keywordtrend) {
    
    $keyword = isset($_GET['keyword']) ? urldecode($_GET['keyword']) : " -?- ";
    $xovi_categories = array();
    $xovi_data = array();
    
    
    foreach($keywordtrend as $trenddata) {
        
        $xovi_data['pos']['data'][] = array($trenddata->crawlDate, ($trenddata->position == 0) ? 130 : $trenddata->position);
        $xovi_data['rec']['data'][] = array($trenddata->crawlDate, $trenddata->resultCount); 
    }
    
    $xovi_data['pos']['series'] = array("label" => $keyword);
    $xovi_data['rec']['series'] = array("label" => $keyword);
    
    return array(
        'pos' => array(
            "container" => "xovichart_monitoringPosition",
            
            "isPositionchart" => true,            
            "title" => "Monitoring - Position",
                        
            "series" => array($xovi_data['pos']['series']),
            "data" => array($xovi_data['pos']['data'])
        ),
        'rec' => array(
            "container" => "xovichart_monitoringResultcount",            
            "isPositionchart" => false,
            "title" => "Monitoring ResultCount",                        
            "series" => array($xovi_data['rec']['series']),
            "data" => array($xovi_data['rec']['data'])
        )
    );  

    
}


function xovi_createKeywordtrendChart($keyword) {
    
    global $xovi_options;
    
    $xovi_categories = array();
    $xovi_data = array();
   
    foreach( xovi_mySearchEngines($xovi_options["xovi[suma]"]) as $sengine ) {   
        $keywordtrend[$sengine] = xovi_myKeywordTrend($keyword, $sengine);
    } 
    $currentSengineNum = 0;
    $gotCategories = false;    
    foreach($keywordtrend as $sengine => $keyworddata) {               
        foreach($keyworddata as $val) {            
            $xovi_data['data'][$currentSengineNum][] = array( (string)$val->date, ( (integer) $val->position === 0 ) ? 130 : $val->position );
        }
        $xovi_data['labels'][$currentSengineNum] = array("label" => $sengine);                                
        $currentSengineNum++;
    }

    return array(
        "container" => "xovichart_keywordTrend",
        "isPositionchart" => true,         
        "data" => $xovi_data['data'],
        "series" => $xovi_data['labels']
    );
    
}



?>