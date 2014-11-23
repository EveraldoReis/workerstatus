<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

/**
 * HelloWorld Model
 */
class CardapioModelItems extends JModelItem
{

    public $menuparams;

    public function getTable($type = 'Item', $prefix = 'CardapioTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    protected function getListQuery()
    {
        // Create a new query object.
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        // Select some fields
        $query->select('*');
        // From the hello table
        $query->from('#__cardapio_items');
        return $query;
    }

    public function getItems()
    {
        $db = JFactory::getDbo();

        $query            = $db->getQuery(true);
        $query->select('a.*');
        $query->join('inner', '#__cardapio_categories AS c ON c.id = a.category_id');
        $query->from('#__cardapio_items AS a');
        $input            = JFactory::getApplication()->input;
        $menuitemid       = $input->getInt('Itemid');  // this returns the menu id number so you can reference parameters
        $menu             = JSite::getMenu();
        $this->menuparams = $menu->getParams($menuitemid);
        if ($catid            = $this->menuparams->get('category_id'))
        {
            $catid = implode(' OR category_id = ', $catid);
            $query->where("a.category_id = $catid");
        }
        if ($carid = $this->menuparams->get('cardapio_id'))
        {
            $carid = implode(' OR cardapio_id = ', $carid);
            $query->where("a.cardapio_id = $carid");
        }
        $db->setQuery($query);
        $result = $db->loadObjectList();
        return $result;
    }

    public function getSizes()
    {
        $db = JFactory::getDbo();

        $query  = $db->getQuery(true);
        $query->select('a.*');
        $query->from('#__cardapio_sizes AS a');
        $db->setQuery($query);
        $result = $db->loadObjectList();
        $sizes  = array();

        foreach ($result as $size)
        {
            $sizes[$size->name] = $size->image;
        }
        return $sizes;
    }

    public function getPricesLabel()
    {
        $db = JFactory::getDbo();

        $query            = $db->getQuery(true);
        $query->select('a.label');
        $query->group('label');
        $query->from('#__cardapio_prices AS a');
        $query->join('inner', '#__cardapio_items AS b ON b.id = a.item_id');
        $query->join('inner', '#__cardapio_categories AS c ON c.id = b.category_id');
        $query->join('inner', '#__cardapio_cardapios AS d ON d.id = b.cardapio_id');
        $query->where(array(
            'a.label != ""'));
        $input            = JFactory::getApplication()->input;
        $menuitemid       = $input->getInt('Itemid');  // this returns the menu id number so you can reference parameters
        $menu             = JSite::getMenu();
        $this->menuparams = $menu->getParams($menuitemid);
        if ($catid            = $this->menuparams->get('category_id'))
        {
            $catid = implode(' OR c.id = ', $catid);
            $query->where("c.id = $catid");
        }
        if ($carid = $this->menuparams->get('cardapio_id'))
        {
            $carid = implode(' OR d.id = ', $carid);
            $query->where("d.id = $carid");
        }
        $db->setQuery($query);
        $result = $db->loadObjectList();
        return $result;
    }

    // Get pagination
    function getPagination()
    {
        // Lets load the content if it doesn't already exist
        if (empty($this->_pagination))
        {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination(count($this->getItems()), $this->getState('limitstart'),
                    $this->getState('limit'));
        }
        return $this->_pagination;
    }

}
