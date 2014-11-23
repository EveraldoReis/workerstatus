{JHtml::_('behavior.tooltip')}
{JHtml::_('behavior.multiselect')}
<form action="{JRoute::_('index.php?option=com_workerstatus&view=businesses')}" method="post" name="adminForm" id="adminForm">
    {$this->loadTemplate('filter')}
    <table class="adminlist">
        <thead>{$this->loadTemplate('head')}</thead>
        <tfoot>{$this->loadTemplate('foot')}</tfoot>
        <tbody>{$this->loadTemplate('body')}</tbody>
    </table>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        {JHtml::_('form.token')}
    </div>
</form>