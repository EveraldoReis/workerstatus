<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 */
class JFormFieldSize extends JFormFieldList
{
        /**
         * The field type.
         *
         * @var         string
         */
        protected $type = 'Size';
 
        /**
         * Method to get a list of options for a list input.
         *
         * @return      array           An array of JHtml options.
         */
        protected function getOptions($selected = null) 
        {
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('id,name');
                $query->from('#__workerstatus_sizes');
                $db->setQuery((string)$query);
                $db->query();
                $messages = $db->loadObjectList();
                $options = array();
                if ($messages)
                {
                        foreach($messages as $message) 
                        {
                                $options[] = JHtml::_('select.option', $message->name, $message->name);
                        }
                }
                $options = array_merge(parent::getOptions(), $options);
                return $options;
        }
}