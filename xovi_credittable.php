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
<?php

    
    $xovi_credits = xovi_myCredits();      
    if(!empty($xovi_credits)) {
        $creditsTotal = ($xovi_credits->additionalCreditamount > 0) ? number_format(($xovi_credits->creditamount - $xovi_credits->additionalCreditamount),0,XOVI_DECIMAL,XOVI_THOUSANDSTEP)."( + ".
                                                             number_format($xovi_credits->additionalCreditamount,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP)." )"
                                                           : number_format($xovi_credits->creditamount,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP);
        
        $creditsUsed = number_format($xovi_credits->creditsused,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP);
        $creditsLeft = number_format($xovi_credits->creditsleft,0,XOVI_DECIMAL,XOVI_THOUSANDSTEP);        
?>                
        <tr valign="top">
            <th scope="row"><?php echo __('Credits total','xovi');?></th>
            <td class="">
<?php
        echo $creditsTotal;
?>
            </td>
        </tr>
        <tr>
            <th class=""><?php echo __('Credits used','xovi');?></th>
            <td class="">
<?php
        echo $creditsUsed;
?>              
            </td>
        </tr>
        <tr>
            <th class=""><?php echo __('Credits left','xovi');?></th>
            <td class="">
<?php
        echo $creditsLeft;
?>
            </td>
        </tr>    
<?php
    } else {
?>         
        <tr>
            <td colspan="2">
               <div id=""> 
                     <p><strong class="error center"><?php echo __('No API-Token found!','xovi');?></strong></p>
                </div>                 
            </td>            
        </tr>     
<?php        
    }
    
?>        
    </tbody>
</table>