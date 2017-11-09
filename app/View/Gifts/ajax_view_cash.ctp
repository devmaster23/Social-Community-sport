<?php
$listHTML = '';
if(! empty($gifts))
{
    $listHTML = '';
    foreach($gifts as $gifts)
    :
        
        if($gifts['Gift']['type'] == 1)
        {
            $amtPrice = __dbt('Product Price');
        }
        else 
            if($gifts['Gift']['type'] == 2)
            {
                $amtPrice = __dbt('Cash Order Amount');
            }
            else
            {
                $amtPrice = __dbt('Amount');
            }
        $giftId = $gifts['Gift']['id'];
        $giftname = $gifts['Gift']['name'];
        $catname = $gifts['GiftCategory']['name'];
        $amount = $gifts['Gift']['amount'];
        $giftname = $gifts['Gift']['name'];
        $href = $gifts['Gift']['product_link'];
        
        $listHTML .= '<tr>
                        <td><input type="radio" name="data[CricketPrediction][gift_id]" id="selectGift" value="' . $amount . '" class="radioinput">&nbsp;</td>
                        <td>' . $this->Text->truncate($catname) . '&nbsp;</td>
                        <td>' . $this->Text->truncate($amtPrice) . '&nbsp;</td>
                        <td class="calcamount" id="amount_id_' . $this->Text->truncate($giftId) . '" data-amount="' . $this->Text->truncate($amount) . '">' . $amount . '&nbsp;</td>
                    </tr>';
    endforeach
    ;
}
$pager = "0";
if(! empty($this->params["paging"]["Gift"]["nextPage"]))
{
    
    $pager = $this->Paginator->next('LOAD MORE GIFTS', array(
        'onclick' => 'return gohere(this.href);'
    ), null);
}
$arr = array(
    "html" => $listHTML,
    "page" => $pager
);
echo json_encode($arr);
