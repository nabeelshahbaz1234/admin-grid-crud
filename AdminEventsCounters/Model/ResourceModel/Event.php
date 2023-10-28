<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * @class Event
 */
class Event extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('event', 'event_id');
    }
}
