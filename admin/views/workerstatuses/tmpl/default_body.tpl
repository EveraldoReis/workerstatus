{foreach from=$this->persons key=i item=person}
    <tr class="row{$i%2}">
        <td>
            {JHtml::_('grid.id', $i, $person->id)}
        </td>
        <td>{JHtml::_('jgrid.published', $person->state, $i, 'workerstatuses.', true)}</td>
        <td>
            <a href="{JRoute::_("index.php?option=com_workerstatus&task=workerstatus.edit&id={$person->id}")}">
                {$person->name}
            </a>
        </td>
        <td>
            {$person->id}
        </td>
    </tr>
{/foreach}