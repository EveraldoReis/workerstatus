<?php

// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * Hello Table class
 */
class WorkerstatusTableWorkerstatus extends JTable
{

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db)
    {
        parent::__construct('#__workerstatus_workerstatuses', 'id', $db);
    }

    /**
     * 
     * @param type $table
     */
    protected function prepareTable($table)
    {
        $table->params = json_encode($table->params);
        $table->rules = json_encode($table->rules);
    }

}
