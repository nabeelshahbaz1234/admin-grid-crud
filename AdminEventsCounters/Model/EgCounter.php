<?php

namespace EGSolution\AdminEventsCounters\Model;

use EGSolution\AdminEventsCounters\Api\Data\EgCounterInterface;
use EGSolution\AdminEventsCounters\Model\ResourceModel\EgCounter as EgCounterResource;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class EgCounter extends AbstractModel implements EgCounterInterface, IdentityInterface
{
    protected $_idFieldName = 'entity_id';

    protected $_eventPrefix = 'EGSolution_AdminEventsCounters_eg_counter';

    public function getId()
    {
        return $this->_getData('entity_id');
    }

    public function getTitle()
    {
        return $this->_getData('title');
    }

    public function setTitle($title)
    {
        return $this->setData('title', $title);
    }

    public function getDescription()
    {
        return $this->_getData('description');
    }

    public function setDescription($description)
    {
        return $this->setData('description', $description);
    }

    public function getStoreView()
    {
        return $this->_getData('store_view');
    }

    public function setStoreView($storeView)
    {
        return $this->setData('store_view', $storeView);
    }

    public function getStatus()
    {
        return $this->_getData('status');
    }

    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    public function getLatitude()
    {
        return $this->_getData('latitude');
    }

    public function setLatitude($latitude)
    {
        return $this->setData('latitude', $latitude);
    }

    public function getLongitude()
    {
        return $this->_getData('longitude');
    }

    public function setLongitude($longitude)
    {
        return $this->setData('longitude', $longitude);
    }

    public function getCreatedAt()
    {
        return $this->_getData('created_at');
    }

    public function getUpdatedAt()
    {
        return $this->_getData('updated_at');
    }

    public function getIdentities()
    {
        // TODO: Implement getIdentities() method.
    }

    protected function _construct()
    {
        $this->_init(EgCounterResource::class);
    }
}
