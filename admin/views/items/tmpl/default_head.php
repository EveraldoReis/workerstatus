<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
        <th width="20">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        </th>   
        <th width="30">
                <?php echo JText::_('COM_CARDAPIO_GENERIC_HEADING_STATE'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_CARDAPIO_GENERIC_HEADING_NAME'); ?>
        </th>  
        <th>
                <?php echo JText::_('COM_CARDAPIO_GENERIC_HEADING_CARDAPIO'); ?>
        </th>  
        <th>
                <?php echo JText::_('COM_CARDAPIO_GENERIC_HEADING_CATEGORY'); ?>
        </th>               
        <th width="5">
                <?php echo JText::_('COM_CARDAPIO_GENERIC_HEADING_ID'); ?>
        </th>                
</tr>