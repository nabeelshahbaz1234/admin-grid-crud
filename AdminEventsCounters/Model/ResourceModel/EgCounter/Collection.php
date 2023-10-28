<?php

namespace EGSolution\AdminEventsCounters\Model\ResourceModel\EgCounter;

use EGSolution\AdminEventsCounters\Model\EgCounter;
use EGSolution\AdminEventsCounters\Model\ResourceModel\EgCounter as EgCounterResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct(): void
    {
        $this->_init(EgCounter::class, EgCounterResource::class);
    }
}
