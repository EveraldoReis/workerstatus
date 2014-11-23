<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach ($this->persons as $i => $person): ?>
    <tr class="row<?php echo $i % 2; ?>">
        <td>
            <?php echo JHtml::_('grid.id', $i, $person->id); ?>
        </td>
        <td><?php echo JHtml::_('jgrid.published', $person->state, $i, 'persons.', true); ?></td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_workerstatus&task=person.edit&id=' . (int) $person->id); ?>">
                <?php echo $person->name; ?>
            </a>
        </td>
        <td>
            <?php echo $person->workerstatus_name; ?>
        </td>
        <td>
            <?php echo $person->business_name; ?>
        </td>
        <td>
            <?php echo $person->id; ?>
        </td>
    </tr>
<?php endforeach; ?>