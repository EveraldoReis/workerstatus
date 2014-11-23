<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php
foreach ($this->items as $item):
    $prices = array();

    $item->complex_price = json_decode($item->complex_price);

    foreach ($item->complex_price->label as $k => $label)
    {
        $prices[$item->complex_price->label->$k] = $item->complex_price->value->$k;
    }
    ?>
    <div class="item">
        <?php if (!empty($item->image)): ?>
            <img src="<?php echo $this->baseUrl . $item->image; ?>" />
        <?php endif; ?>
        <?php if (!empty($item->name)): ?>
            <h3><a href="<?php echo JRoute::_('index.php?option=com_cardapio&view=item&id=' . $item->id); ?>"><?php echo $item->name; ?></a></h3>
        <?php endif; ?>
        <?php if (!empty($item->ingredients)): ?>
            <p><h5>Ingredientes</h5><?php echo $item->ingredients; ?></p>
    <?php endif; ?>
    <?php if (!empty($item->description_long)): ?>
        <p><h5>Descrição</h5><?php echo $item->description_long; ?></p>
    <?php endif; ?>
    <div class="prices">
        <?php foreach ($this->labels as $label): ?>
            <div>
                <h5><?php echo $label->label; ?></h5>
                <?php echo isset($prices[$label->label]) ? $prices[$label->label] : '-'; ?>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
<?php endforeach; ?>