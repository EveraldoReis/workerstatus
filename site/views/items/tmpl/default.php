<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table class="items">
    <?php
    foreach ($this->items as $item):
        $prices = array();

        $item->complex_price = json_decode($item->complex_price);

        foreach ($item->complex_price->label as $k => $label)
        {
            $prices[$item->complex_price->label[$k]] = $item->complex_price->value[$k];
        }
        ?><tr class="item">
            <td>
                <a href="<?php echo $this->baseUrl . $item->image; ?>" class="modal" rel="{helper: 'image'}"><?php if($item->image): ?><img style="width: 80px;" src="<?php echo $this->baseUrl . $item->image; ?>" /><?php endif; ?></a>
            </td>
            <td>
                <h3>
                    <a class="modal" rel="{helper: 'ajax'}" href="<?php echo JRoute::_('index.php?option=com_cardapio&view=item&id=' . $item->id); ?>">
                        <?php echo $item->name; ?>
                    </a>
                </h3>
            </td>
            <td><p><?php echo $item->ingredients ? $item->ingredients : '-'; ?></p></td>
            <td><p><?php echo $item->description_long ? $item->description_long : '-'; ?></p></td>
            <?php foreach ($this->labels as $label): ?>
            <td style="width: 100px;line-height: 50px;"><?php if(isset($prices[$label->label])): ?><div style="display: inline-block; float: left;"><div style="width:48px; height: 48px; display: block; float: left; margin: 0 5px; background-image: url('<?php echo $this->sizes[$label->label]; ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;" width="48" /></div> <div style="float: right; display: inline-block;"><?php echo isset($prices[$label->label]) ? $prices[$label->label] : '-'; ?></div><?php endif; ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>