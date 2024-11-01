<div class="wrap">    
    <h2><?php echo __( 'Settings', 'xovi').XOVI_PLUGINTITLE;?></h2>
<?php

/* Wurden einstellungen geändert, werden sie hier verarbeitet! */
if(isset($_POST) && !empty($_POST) && isset($_POST["submit"])) {
    update_option('xovi_options_vars', array(
        "xovi[domain]" => isset($_POST["xovi"]["domain"]) ? str_replace("http://", "", $_POST["xovi"]["domain"]) : str_replace("http://", "", $xovi_options["xovi[domain]"]),
        "xovi[apitoken]" => isset($_POST["xovi"]["apitoken"]) ? $_POST["xovi"]["apitoken"] : $xovi_options["xovi[apitoken]"],
        "xovi[suma]" => isset($_POST["xovi"]["suma"]) ? array_sum($_POST["xovi"]["suma"]) : $xovi_options["xovi[suma]"],
        "xovi[weeks]" => isset($_POST["xovi"]["weeks"]) ? $_POST["xovi"]["weeks"] : $xovi_options["xovi[weeks]"],
        "xovi[hits]" => isset($_POST["xovi"]["hits"]) ? $_POST["xovi"]["hits"] : $xovi_options["xovi[hits]"],
        "xovi[dashboardwidgets]" => isset($_POST["xovi"]["dashboardwidgets"]) ? array_sum($_POST["xovi"]["dashboardwidgets"]) : $xovi_options["xovi[dashboardwidgets]"]
    ));
    
   
    
    echo xovi_createMessage(__('Settings Saved!','xovi'), 'update');
}      

$xovi_options = get_option('xovi_options_vars');

?>  
    <form method="post" action="">
    <table>
        <thead></thead>
        <tfoot></tfoot>
        <tbody>
            <tr>
                <td>
                    
                    <h3><?php echo __('General Settings', 'xovi');?></h3>
                    <table class="form-table">
                        <thead></thead>
                        <tfoot></tfoot>
                        <tbody>
                            <tr valign="top">
                                <th scope="row"><label for="xovi_domain"><?php echo __( 'Domain' );?></label></th>
                                <td><input name="xovi[domain]" type="text" id="xovi_domain" value="<?php echo $xovi_options['xovi[domain]']; ?>" class="regular-text"></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><label for="xovi_apitoken"><?php echo __( 'API - Token');?></label></th>
                                <td><input name="xovi[apitoken]" type="text" id="xovi_apitoken" value="<?php echo $xovi_options['xovi[apitoken]']; ?>" class="regular-text">
                                    <p class="description"><?php echo __( 'No API-Token, yet? - ', 'xovi' ).sprintf('<a href="http://suite.xovi.net/api" target="blank">%1$s</a>', __( 'Get your API-Token here!', 'xovi' ) ) ?></p>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php echo __( 'Search Engines' ,'xovi');?></th>
                                <td>
                                    <fieldset>                            
                                        <input id="xovi_sengine_googlede" type="checkbox" name="xovi[suma][]" value="1" <?php echo xovi_isSumaChecked($xovi_options["xovi[suma]"], 1) ?>>
                                        <label for="xovi_sengine_googlede">google.de</label><br />
                                        <input id="xovi_sengine_googleat" type="checkbox" name="xovi[suma][]" value="2" <?php echo xovi_isSumaChecked($xovi_options["xovi[suma]"], 2) ?>>
                                        <label for="xovi_sengine_googleat">google.at</label><br />
                                        <input id="xovi_sengine_googlech" type="checkbox" name="xovi[suma][]" value="4" <?php echo xovi_isSumaChecked($xovi_options["xovi[suma]"], 4) ?>>
                                        <label for="xovi_sengine_googlech">google.ch</label><br />
                                        <input id="xovi_sengine_bingde" type="checkbox" name="xovi[suma][]" value="8" <?php echo xovi_isSumaChecked($xovi_options["xovi[suma]"], 8) ?>>
                                        <label for="xovi_sengine_bingde">bing.com (de)</label><br />
                                        <input id="xovi_sengine_googlecom" type="checkbox" name="xovi[suma][]" value="16" <?php echo xovi_isSumaChecked($xovi_options["xovi[suma]"], 16) ?>>
                                        <label for="xovi_sengine_googlecom">google.com</label><br />
                                        <input id="xovi_sengine_googlecouk" type="checkbox" name="xovi[suma][]" value="32" <?php echo xovi_isSumaChecked($xovi_options["xovi[suma]"], 32) ?>>
                                        <label for="xovi_sengine_googlecouk">google.co.uk</label><br />
                                        <input id="xovi_sengine_googlefr" type="checkbox" name="xovi[suma][]" value="64" <?php echo xovi_isSumaChecked($xovi_options["xovi[suma]"], 64) ?>>
                                        <label for="xovi_sengine_googlefr">google.fr</label><br />
                                        <input id="xovi_sengine_googlees" type="checkbox" name="xovi[suma][]" value="128" <?php echo xovi_isSumaChecked($xovi_options["xovi[suma]"], 128) ?>>
                                        <label for="xovi_sengine_googlees">google.es</label><br />
                                        <input id="xovi_sengine_googleit" type="checkbox" name="xovi[suma][]" value="256" <?php echo xovi_isSumaChecked($xovi_options["xovi[suma]"], 256) ?>>
                                        <label for="xovi_sengine_googleit">google.it</label><br />
                                    </fieldset>
                                    <p class="description"><?php echo __( 'Choose search engines that will be considered.' , 'xovi' );?></p>
                                </td>
                            </tr>          
                        </tbody>
                    </table>
                    <h3><?php echo __('Charts', 'xovi');?></h3>
                    <table class="form-table">
                        <thead></thead>
                        <tfoot></tfoot>
                        <tbody>                            
                            <tr valign="top">
                                <th scope="row"><label for="xovi_ovichart_interval"><?php echo __('Number of Weeks','xovi');?></label></th>
                                <td><input name="xovi[weeks]" type="text" id="xovi_ovichart_interval" value="<?php echo $xovi_options['xovi[weeks]']; ?>" class="regular-text">
                                    <p class="description"><?php echo __('Choose the number of weeks being shown in the chart.', 'xovi');?></p>
                                </td>
                            </tr>
                            <tr>
                                                                
                            </tr>
                        </tbody>
                    </table>
                    <h3><?php echo __('Results', 'xovi');?></h3>
                    <table class="form-table">
                        <thead></thead>
                        <tfoot></tfoot>
                        <tbody>                            
                            <tr valign="top">
                                <th scope="row"><label for="xovi_rankings_interval"><?php echo __('Number of Results','xovi');?></label></th>
                                <td><input name="xovi[hits]" type="text" id="xovi_rankings_interval" value="<?php echo $xovi_options['xovi[hits]']; ?>" class="regular-text">
                                    <p class="description"><?php echo __('Choose the number of results you want to get.','xovi');?></p>
                                </td>
                            </tr>  
                        </tbody>
                    </table>  
                    <h3><?php echo __('Dashboard Widget', 'xovi');?></h3>
                    <table class="form-table">
                        <thead></thead>
                        <tfoot></tfoot>
                        <tbody>
                            <tr valign="top">
                                <th scope="row"><?php echo __('Dashboard Widgets','xovi');?></th>
                                <td>                                    
                                    <input name="xovi[dashboardwidgets][]" type="checkbox" id="xovi_dashboardwidget_credits" value="1" <?php echo xovi_isWidgetChecked($xovi_options["xovi[dashboardwidgets]"], 1) ?>>
                                    <label for="xovi_dashboardwidget_credits"><?php echo __('Show Credits','xovi');?></label><br />                                                                      
                                    <input name="xovi[dashboardwidgets][]" type="checkbox" id="xovi_dashboardwidget_monitore" value="2" <?php echo xovi_isWidgetChecked($xovi_options["xovi[dashboardwidgets]"], 2) ?>>
                                    <label for="xovi_dashboardwidget_monitore"><?php echo __('Show Monitoring','xovi');?></label><br />                                                                        
                                    <input name="xovi[dashboardwidgets][]" type="checkbox" id="xovi_dashboardwidget_charts_ovi" value="4" <?php echo xovi_isWidgetChecked($xovi_options["xovi[dashboardwidgets]"], 4) ?>>
                                    <label for="xovi_dashboardwidget_charts_ovi"><?php echo __('Show SEO Trends','xovi');?></label><br />                                    
                                    <p class="description"><?php echo __('Choose which tool you want to add to the dashboard.','xovi');?></p>
                                </td>
                            </tr>                             
                        </tbody>
                    </table>   
                    <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php echo __('save changes','xovi');?>"></p>
                   

                </td>
                <td style="width:40%; vertical-align: top;">
<?php

if(!empty($xovi_options["xovi[apitoken]"])) {
    
    echo "<h3>".__('Credits', 'xovi')."</h3>";
    include(__DIR__."/xovi_credittable.php");
} 

?>             
                    
                    
                                 
                </td>         
            </tr>
        </tbody>
    </table>
    </form>
</div>




