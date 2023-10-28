<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Api\Data;

interface EventInterfaceSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    public function getItems();

    public function setItems(array $items);
}

