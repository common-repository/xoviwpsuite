<?php
/*
Plugin Name: XOVI Wordpress Suite
Plugin URI: http://www.xovi.de/
Description: Monitore your Blog with always fresh seo data from XOVI - The Online-Marketing Suite
Version: 2.0
Author: XOVI
Author URI: http://www.xovi.de/
*/
 
ini_set('max_execution_time', 60);  // to get sure big api-requests will be processed
error_reporting(1);

if(!defined('__DIR__')) {
    define("__DIR__", dirname(__FILE__) );    
}

/**
 * Load variables
 */
add_option('xovi_options_vars', array(
    "xovi[domain]" => str_replace("http://","",(isset($xovi_options["xovi[domain]"]) ? $xovi_options["xovi[domain]"] : site_url())),
    "xovi[apitoken]" => isset($xovi_options["xovi[apitoken]"]) ? $xovi_options["xovi[apitoken]"] : "",
    "xovi[suma]" => isset($xovi_options["xovi[suma]"]) ? $xovi_options["xovi[suma]"] : 15,
    "xovi[weeks]" => isset($xovi_options["xovi[hits]"]) ? $xovi_options["xovi[hits]"] : 12,    
    "xovi[hits]" => isset($xovi_options["xovi[hits]"]) ? $xovi_options["xovi[hits]"] : 25,
    "xovi[dashboardwidgets]" => isset($xovi_options["xovi[dashboardwidgets]"]) ? $xovi_options["xovi[dashboardwidgets]"] : 3
));

$xovi_options = get_option('xovi_options_vars');
// enable Multi-Language and set properties based on current language
load_plugin_textdomain( 'xovi', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

switch(get_bloginfo('language')) {
    
    case 'de-DE':
        $xovi_decimal = ',';
        $xovi_thousandstep = '.';
      break;
    default: 
        $xovi_decimal = '.';
        $xovi_thousandstep = ',';
      break;
}
define("XOVI_DECIMAL", $xovi_decimal);
define("XOVI_THOUSANDSTEP", $xovi_thousandstep);   
define("XOVI_PLUGINTITLE", " | XOVI Wordpress Suite");
define("XOVI_CURRENT_PAGE", admin_url('admin.php?page='.$_GET['page']));     // currently shown page

// include functions
include(__DIR__.'/xovi_apiconnect.php'); //   API   Functions
include(__DIR__.'/xovi_charts.php');     //  Chart  Functions
include(__DIR__.'/xovi_functions.php');  // General Functions


// Create Menu and Submenus 
if(!function_exists("xovi_addAdminMenu")) {
    function xovi_addAdminMenu() {    
        add_menu_page("XOVI WP Suite", "XOVI WP Suite", 10, __FILE__, 'xovi_showPreferences', plugins_url( 'images/xovi.png' , __FILE__ ));
        add_submenu_page(__FILE__, __('Settings','xovi'), __('Settings','xovi'), 10, __FILE__ , 'xovi_showPreferences');
        add_submenu_page(__FILE__, __('SEO Trends','xovi'), __('SEO Trends','xovi'), 10, __DIR__.'/xovi_seo.php', '');
        add_submenu_page(__FILE__, __('Rankings','xovi'), __('Rankings','xovi'), 10, __DIR__.'/xovi_rankings.php', '');
        add_submenu_page(__FILE__, __('Lostkeywords','xovi'), __('Lostkeywords','xovi'), 10, __DIR__.'/xovi_lostkeywords.php', '');
        add_submenu_page(__FILE__, __('Wonkeywords','xovi'), __('Wonkeywords','xovi'), 10, __DIR__.'/xovi_wonkeywords.php', '');
        add_submenu_page(__FILE__, __('pages','xovi'), __('pages','xovi'), 10, __DIR__.'/xovi_pages.php', '');
        add_submenu_page(__FILE__, __('Rankingvalue','xovi'), __('Rankingvalue','xovi'), 10, __DIR__.'/xovi_rankingvalue.php','');
        add_submenu_page(__FILE__, __('Keyword Monitoring','xovi'), __('Keyword Monitoring','xovi'), 10, __DIR__.'/xovi_monitoring.php', '');
        add_submenu_page(__FILE__, __('Backlinks','xovi'), __('Backlinks','xovi'), 10, __DIR__.'/xovi_backlinks.php','');
        add_submenu_page(__FILE__, __('Reportings','xovi'), __('Reportings','xovi'), 10, __DIR__.'/xovi_reporting.php','');      
        add_submenu_page(__FILE__, __('Signals','xovi'), __('Signals','xovi'), 10, __DIR__.'/xovi_socialsignals.php','');      
    }
}
add_action('admin_menu', 'xovi_addAdminMenu');

// xovi WP Suite - show Setting's page on startup */
function xovi_showPreferences() {
    include(__DIR__."/xovi_preferences.php");
}

// Create A Box on Dashboard, if checkbox is selected
if((int)$xovi_options['xovi[dashboardwidgets]'] > 0) {
    
    // Create an additional Box on Dashboard ....
    function xovi_dashboard_box() {
        include(__DIR__."/xovi_dashboard_widget.php");
    }
    // .... and fill values via wp_add_dashboard_widget()
    function xovi_dashboard_setup() {    
        wp_add_dashboard_widget( 'xovi_dashboard_box', 'XOVI Wordpress Suite', 'xovi_dashboard_box' );
    }
    add_action('wp_dashboard_setup', 'xovi_dashboard_setup');

}

// Add Scripts and Styles
function xovi_includes() {  
    
    wp_enqueue_style( 'jqplotStyle', plugins_url("css/jquery.jqplot.css", __FILE__ ), false );    
    wp_enqueue_style( 'xovi_style', plugins_url('css/stylesheet.css', __FILE__), false );    
    wp_enqueue_script( 'jqplotCore', plugins_url("javascript/jquery.jqplot.min.js", __FILE__), false );    
    wp_enqueue_script( 'jqplotHighlight', plugins_url("javascript/plugins/jqplot.highlighter.min.js", __FILE__),false);
    wp_enqueue_script( 'jqplotCursor', plugins_url("javascript/plugins/jqplot.cursor.min.js", __FILE__),false);
    wp_enqueue_script( 'jqplotDateRenderer', plugins_url('javascript/plugins/jqplot.dateAxisRenderer.min.js', __FILE__),false);        
    wp_enqueue_script( 'chartOptions', plugins_url("javascript/chartoptions.js", __FILE__ ), false);
    
}

add_action('admin_enqueue_scripts', 'xovi_includes');



?>
