<?php

// No direct access to this file
defined('_JEXEC') or die;

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldPrice extends JFormField
{

    /**
     * The field type.
     *
     * @var         string
     */
    protected $type = 'Price';

    function getInput($item = null)
    {
        require 'size.php';

        $values             = $item->complex_price;
        $doc                = JFactory::getDocument();
        $doc->addScript('//code.jquery.com/jquery-1.11.0.min.js');
        $doc->addScript('//code.jquery.com/jquery-migrate-1.2.1.min.js');
        $input              = JFactory::getApplication()->input;
        $output             = '<div style="float: left;" id="prices">';
        $type               = $input->get('price_type') ? $input->get('price_type', 0) : JFactory::getApplication()->getUserState('com_cardapio.price_type',
                        0);
        if (!$type && is_object($item))
            $type               = $item->price_type;
        $sizeText           = JText::_('COM_CARDAPIO_GENERIC_HEADING_SIZE');
        $valueText          = JText::_('COM_CARDAPIO_GENERIC_HEADING_VALUE');
        $addText            = JText::_('COM_CARDAPIO_GENERIC_ADD_VARIATION');
        $removeText         = JText::_('COM_CARDAPIO_GENERIC_REMOVE');
        $alterPriceTypeText = JText::_('COM_CARDAPIO_GENERIC_ALTER_PRICE_TYPE');
        $multiplePriceText  = JText::_('COM_CARDAPIO_GENERIC_MULTIPLE_PRICE_TYPE');
        $singlePriceText    = JText::_('COM_CARDAPIO_GENERIC_SINGLE_PRICE_TYPE');
        if ($type === 'multiple_price')
        {
            $doc->addScriptDeclaration(''
                    . 'window.addEventListener("DOMContentLoaded", function(){'
                    . ' var tmpl = $("#prices .price").first().clone();'
                    . ' var prices = $("#prices");'
                    . ' $(document).on("click", ".price_button", function(){ '
                    . '     var btn = $(this);'
                    . '     if(btn.hasClass("add")){'
                    . '         tmpl2 = tmpl.clone();'
                    . '         tmpl2.find(".rpt").remove();'
                    . '         tmpl2.find(".price_button").removeClass("add").addClass("remove").html("Remover");'
                    . '         tmpl2.find(".price_label").attr("readonly", false).val("");'
                    . '         tmpl2.find(".price_value").attr("readonly", false).val("");'
                    . '         $("#prices .price").first().after(tmpl2)'
                    . '     }'
                    . '     if(btn.hasClass("remove")){'
                    . '         btn.parents(".price").remove();'
                    . '     }'
                    . ' });'
                    . '});'
            );
            $size = new JFormFieldSize;
            $output .= '<div class="price">'
                    . '<div style="display: inline-block;">' . $sizeText . '<br/><select class="price_label" name="jform[complex_price][label][]">' . $this->options() . '</select></div>'
                    . '<div style="display: inline-block;">' . $valueText . '<br/><input class="price_value" size="10" type="text" name="jform[complex_price][value][]" /></div>'
                    . '<div style="display: inline-block;"><br/><button style="display: inline-block; float: right;" type="button" class="price_button add">' . $addText . '</button></div>'
                    . '<div class="rpt" style="display: inline-block;"><br/><button onclick="Joomla.submitbutton(\'item.rpt\');">' . $alterPriceTypeText . '</button></div>'
                    . '</div>';
            if ($values)
            {
                foreach ($values->label as $key => $label)
                {
                    $output .= '<div class="price">'
                            . '<div style="display: inline-block;">' . $sizeText . '<br/><select class="price_label" name="jform[complex_price][label][]">' . (isset($values->label[$key]) ? $this->options($values->label[$key]) : null) . '</select></div>'
                            . '<div style="display: inline-block;">' . $valueText . '<br/><input class="price_value" size="10" type="text" name="jform[complex_price][value][]" value="' . (isset($values->value[$key]) ? $values->value[$key] : null) . '" /></div>'
                            . '<div style="display: inline-block;"><br/><button style="display: inline-block; float: right;" type="button" class="price_button remove">' . $removeText . '</button></div>'
                            . '</div>';
                }
            }
        }
        else if ($type === 'single_price')
        {
            $label = is_object($values) ? end($values->value) : null;
            $output .= '<div class="price">'
                    . '<input type="hidden" name="jform[complex_price][label][0]" value="0" />'
                    . '<div style="display: inline-block;"><input class="price_value" value="' . $label . '" size="10" type="text" name="jform[complex_price][value][0]" /></div>'
                    . '<div style="display: inline-block;"><button onclick="Joomla.submitbutton(\'item.rpt\');">' . $alterPriceTypeText . '</button></div>'
                    . '</div>';
        }
        else
        {
            $doc->addStyleDeclaration('#price_type{padding: 5px 0 0 0;} #price_type > a{padding: 2px 10px; border: 1px solid #aaa;}');
            $output .= '<div id="price_type"><a onclick="if(document.adminForm.jform_name.value != \'\'){event.preventDefault();var input = document.createElement(\'input\');input.name = \'jform[price_type]\';input.value=\'single_price\';input.type=\'hidden\';document.adminForm.appendChild(input);Joomla.submitbutton(\'item.reload\');}" class="btn" href="' . JRoute::_('index.php?option=com_cardapio&view=item&layout=edit&id=' . $input->get('id') . '&price_type=single_price') . '">' . $singlePriceText . '</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="if(document.adminForm.jform_name.value != \'\'){event.preventDefault();var input = document.createElement(\'input\');input.name = \'jform[price_type]\';input.value=\'multiple_price\';input.type=\'hidden\';document.adminForm.appendChild(input);Joomla.submitbutton(\'item.reload\');}" class="btn" href="' . JRoute::_('index.php?option=com_cardapio&view=item&layout=edit&id=' . $input->get('id') . '&price_type=multiple_price') . '">' . $multiplePriceText . '</a></div>';
        }
        return "$output</div>";
    }

    public function options($selected = null)
    {
        $db       = JFactory::getDBO();
        $query    = $db->getQuery(true);
        $query->select('id,name');
        $query->from('#__cardapio_sizes');
        $db->setQuery((string) $query);
        $db->query();
        $messages = $db->loadObjectList();
        $options  = array();
        if ($messages)
        {
            foreach ($messages as $message)
            {
                $options[] = '<option value="' . $message->name . '" ' . ($message->name == $selected ? 'selected' : '') . '>' . $message->name . '</option>';
            }
        }
        return implode($options);
    }

}
