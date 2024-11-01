<div class="wrap">
<?php
if(empty($xovi_options["xovi[apitoken]"])) {
    echo "<h2>".__('Social Signals','xovi').XOVI_PLUGINTITLE."</h2>";    
    echo xovi_createMessage('Kein API-Token hinterlegt!', 'error');
    return;
}

?>
<h2><?php echo __('Social Signals - Summary','xovi').XOVI_PLUGINTITLE;?> </h2>
<?php
        $xovi_signals = xovi_mySocialSignals();   
    if(!empty($xovi_signals)) {   
        
?>
 
<table class="wp-list-table widefat fixed" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" id="" class="" style=""><?php echo __('Title','xovi');?></th>
            <th scope="col" id="" class="" style=""><?php echo __('Value','xovi');?></th>                
        </tr>
    </thead>
    <tfoot>

    </tfoot>
    <tbody id="the-list">
        <tr valign="top">
            <th scope="row"><?php echo __('Facebook Likes','xovi');?></th>
            <td class="">
<?php
    echo number_format($xovi_signals[0]->value,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP);
?>
            </td>
        </tr>
        <tr>
            <th class=""><?php echo __('Facebook Shares','xovi');?></th>
            <td class="">
<?php
    echo number_format($xovi_signals[1]->value,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP);
?>              
            </td>
        </tr>
        <tr>
            <th class=""><?php echo __('Facebook Comments','xovi');?></th>
            <td class="">
<?php
    echo number_format($xovi_signals[2]->value,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP);
?>
            </td>
        </tr>    
        <tr>
            <th class=""><?php echo __('Tweets','xovi');?></th>
            <td class="">
<?php
    echo number_format($xovi_signals[3]->value,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP);
?>
            </td>
        </tr>    
        <tr>
            <th class=""><?php echo __('Google plus','xovi');?></th>
            <td class="">
<?php
    echo number_format($xovi_signals[4]->value,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP);
?>
            </td>
        </tr>    
    </tbody>
</table>

<?php
    } else {
        echo xovi_createMessage(__('No keywords found!','xovi'), 'error');
    }

?>
</div>