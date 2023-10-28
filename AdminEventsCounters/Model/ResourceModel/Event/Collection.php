<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Model\ResourceModel\Event;

use EGSolution\AdminEventsCounters\Model\Event;
use EGSolution\AdminEventsCounters\Model\ResourceModel\Event as EventResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'event_id';
    protected $_eventPrefix = 'eg_event';
    protected $_eventObject = 'event';

    protected function _construct(): void
    {
        $this->_init(Event::class, EventResource::class);
    }
}

