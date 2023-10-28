<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Api;

use EGSolution\AdminEventsCounters\Api\Data\EventInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface EventRepositoryInterface
{
    public function save(EventInterface $event);

    public function getById($eventId);

    public function delete(EventInterface $event);

    public function deleteById($eventId);

    public function getList(SearchCriteriaInterface $searchCriteria);
}
