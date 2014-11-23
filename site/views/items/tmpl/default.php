<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table class="persons">
    <?php
    foreach ($this->persons as $person):
        $prices = array();

        $person->complex_price = json_decode($person->complex_price);

        foreach ($person->complex_price->label as $k => $label)
        {
            $prices[$person->complex_price->label[$k]] = $person->complex_price->value[$k];
        }
        ?><tr class="person">
            <td>
                <a href="<?php echo $this->baseUrl . $person->image; ?>" class="modal" rel="{helper: 'image'}"><?php if($person->image): ?><img style="width: 80px;" src="<?php echo $this->baseUrl . $person->image; ?>" /><?php endif; ?></a>
            </td>
            <td>
                <h3>
                    <a class="modal" rel="{helper: 'ajax'}" href="<?php echo JRoute::_('index.php?option=com_workerstatus&view=person&id=' . $person->id); ?>">
                        <?php echo $person->name; ?>
                    </a>
                </h3>
            </td>
            <td><p><?php echo $person->ingredients ? $person->ingredients : '-'; ?></p></td>
            <td><p><?php echo $person->description_long ? $person->description_long : '-'; ?></p></td>
            <?php foreach ($this->labels as $label): ?>
            <td style="width: 100px;line-height: 50px;"><?php if(isset($prices[$label->label])): ?><div style="display: inline-block; float: left;"><div style="width:48px; height: 48px; display: block; float: left; margin: 0 5px; background-image: url('<?php echo $this->sizes[$label->label]; ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;" width="48" /></div> <div style="float: right; display: inline-block;"><?php echo isset($prices[$label->label]) ? $prices[$label->label] : '-'; ?></div><?php endif; ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>