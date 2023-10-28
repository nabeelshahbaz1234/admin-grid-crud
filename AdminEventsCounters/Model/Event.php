<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Model;

use EGSolution\AdminEventsCounters\Api\Data\EventInterface;
use EGSolution\AdminEventsCounters\Model\ResourceModel\Event as EventResource;
use  Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Event extends AbstractModel implements EventInterface, IdentityInterface
{
    const CACHE_TAG = 'eg_event';

    protected $_idFieldName = 'event_id';

    protected $_eventPrefix = 'eg_event';
    protected $_cacheTag = 'eg_event';

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getEventId()
    {
        return $this->_getData('event_id');
    }

    public function setEventId($eventId)
    {
        return $this->setData('event_id', $eventId);
    }

    public function getEntityId()
    {
        return $this->_getData('entity_id');
    }

    public function setEntityId($entityId)
    {
        return $this->setData('entity_id', $entityId);
    }

    public function getEventName()
    {
        return $this->_getData('event_name');
    }

    public function setEventName($eventName)
    {
        return $this->setData('event_name', $eventName);
    }

    public function getEventStartDate()
    {
        return $this->_getData('event_start_date');
    }

    public function setEventStartDate($startDate)
    {
        return $this->setData('event_start_date', $startDate);
    }

    public function getEventEndDate()
    {
        return $this->_getData('event_end_date');
    }

    public function setEventEndDate($endDate)
    {
        return $this->setData('event_end_date', $endDate);
    }

    public function getStartTime()
    {
        return $this->_getData('start_time');
    }

    public function setStartTime($startTime)
    {
        return $this->setData('start_time', $startTime);
    }

    public function getEndTime()
    {
        return $this->_getData('end_time');
    }

    public function setEndTime($endTime)
    {
        return $this->setData('end_time', $endTime);
    }

    public function getEventStatus()
    {
        return $this->_getData('event_status');
    }

    public function setEventStatus($eventStatus)
    {
        return $this->setData('event_status', $eventStatus);
    }

    public function getEventTitle()
    {
        return $this->_getData('event_title');
    }

    public function setEventTitle($eventTitle)
    {
        return $this->setData('event_title', $eventTitle);
    }

    public function getEventImage()
    {
        return $this->_getData('event_image');
    }

    public function setEventImage($eventImage)
    {
        return $this->setData('event_image', $eventImage);
    }

    public function getCmsBlock()
    {
        return $this->_getData('cms_block');
    }

    public function setCmsBlock($cmsBlock)
    {
        return $this->setData('cms_block', $cmsBlock);
    }

    public function getEventDescription()
    {
        return $this->_getData('event_description');
    }

    public function setEventDescription($eventDescription)
    {
        return $this->setData('event_description', $eventDescription);
    }

    public function getStoreView()
    {
        return $this->_getData('store_view');
    }

    public function setStoreView($storeView)
    {
        return $this->setData('store_view', $storeView);
    }

    public function getUrlKey()
    {
        return $this->_getData('url_key');
    }

    public function setUrlKey($urlKey)
    {
        return $this->setData('url_key', $urlKey);
    }

    public function getMetaTitle()
    {
        return $this->_getData('meta_title');
    }

    public function setMetaTitle($metaTitle)
    {
        return $this->setData('meta_title', $metaTitle);
    }

    public function getMetaKeywords()
    {
        return $this->_getData('meta_keywords');
    }

    public function setMetaKeywords($metaKeywords)
    {
        return $this->setData('meta_keywords', $metaKeywords);
    }

    public function getMetaDescription()
    {
        return $this->_getData('meta_description');
    }

    public function setMetaDescription($metaDescription)
    {
        return $this->setData('meta_description', $metaDescription);
    }

    public function getCreatedAt()
    {
        return $this->_getData('created_at');
    }

    public function getUpdatedAt()
    {
        return $this->_getData('updated_at');
    }

    protected function _construct(): void
    {
        $this->_init(EventResource::class);
    }
}
