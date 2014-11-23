<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php
foreach ($this->persons as $person):
    $prices = array();

    $person->complex_price = json_decode($person->complex_price);

    foreach ($person->complex_price->label as $k => $label)
    {
        $prices[$person->complex_price->label->$k] = $person->complex_price->value->$k;
    }
    ?>
    <div class="person">
        <?php if (!empty($person->image)): ?>
            <img src="<?php echo $this->baseUrl . $person->image; ?>" />
        <?php endif; ?>
        <?php if (!empty($person->name)): ?>
            <h3><a href="<?php echo JRoute::_('index.php?option=com_workerstatus&view=person&id=' . $person->id); ?>"><?php echo $person->name; ?></a></h3>
        <?php endif; ?>
        <?php if (!empty($person->ingredients)): ?>
            <p><h5>Ingredientes</h5><?php echo $person->ingredients; ?></p>
    <?php endif; ?>
    <?php if (!empty($person->description_long)): ?>
        <p><h5>Descrição</h5><?php echo $person->description_long; ?></p>
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