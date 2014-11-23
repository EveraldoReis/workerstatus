<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach ($this->items as $i => $item): ?>
    <tr class="row<?php echo $i % 2; ?>">
        <td>
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
        <td><?php echo JHtml::_('jgrid.published', $item->state, $i, 'cardapios.', true); ?></td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_cardapio&task=cardapio.edit&id=' . (int) $item->id); ?>">
                <?php echo $item->name; ?>
            </a>
        </td>
        <td>
            <?php echo $item->id; ?>
        </td>
    </tr>
<?php endforeach; ?>