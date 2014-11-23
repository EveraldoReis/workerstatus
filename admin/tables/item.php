<?php

// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * Hello Table class
 */
class CardapioTableItem extends JTable
{

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db)
    {
        parent::__construct('#__cardapio_items', 'id', $db);
    }
    
    function store($updateNulls = false)
    {
        $store = parent::store($updateNulls);
        
        $db         = JFactory::getDbo();
        if ($this->id)
        {
            $db->setQuery('DELETE FROM #__cardapio_prices WHERE item_id = ' . $this->id);

            $db->query();
        }
        $this->complex_price = json_decode($this->complex_price);
        foreach ($this->complex_price->label as $k => $label)
        {
            if ('' == trim($label))
                continue;
            $db->setQuery('INSERT IGNORE INTO #__cardapio_prices (`item_id`,`label`,`value`) VALUES ("' . $this->id . '", "' . ucfirst($this->complex_price->label->$k) . '", "' . $this->complex_price->value->$k . '")');

            $db->query();
        }
        
        return $store;
    }
    
}
