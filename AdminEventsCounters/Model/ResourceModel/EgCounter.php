<?php

namespace EGSolution\AdminEventsCounters\Model\ResourceModel;

class EgCounter extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('counter', 'entity_id');
    }
}
