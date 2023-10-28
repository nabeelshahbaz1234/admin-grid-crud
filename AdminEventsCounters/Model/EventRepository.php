<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Model;

use EGSolution\AdminEventsCounters\Api\Data\EventInterface;
use EGSolution\AdminEventsCounters\Api\EventRepositoryInterface;
use EGSolution\AdminEventsCounters\Model\ResourceModel\Event as EventResource;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @class EventRepository
 */
class EventRepository implements EventRepositoryInterface
{
    /**
     * @var EventFactory
     */
    protected EventFactory $eventFactory;
    /**
     * @var EventResource
     */
    protected EventResource $eventResource;
    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;
    /**
     * @var SearchResultsInterfaceFactory
     */
    protected SearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @param EventFactory $eventFactory
     * @param EventResource $eventResource
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        EventFactory                  $eventFactory,
        EventResource                 $eventResource,
        CollectionProcessorInterface  $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->eventFactory = $eventFactory;
        $this->eventResource = $eventResource;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @throws AlreadyExistsException
     */
    public function save(EventInterface $event): void
    {
        $this->eventResource->save($event);
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById($eventId)
    {
        $event = $this->eventFactory->create();
        $this->eventResource->load($event, $eventId);
        if (!$event->getId()) {
            throw new NoSuchEntityException(__('The event with ID %1 does not exist.', $eventId));
        }
        return $event;
    }

    /**
     * @throws Exception
     */
    public function delete(EventInterface $event): void
    {
        $this->eventResource->delete($event);
    }

    /**
     * @throws NoSuchEntityException
     * @throws Exception
     */
    public function deleteById($eventId): void
    {
        $event = $this->getById($eventId);
        $this->delete($event);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->eventFactory->create()->getCollection();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
