<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Model;

use EGSolution\AdminEventsCounters\Api\Data\EgCounterInterface;
use EGSolution\AdminEventsCounters\Api\Data\EgCounterInterfaceFactory;
use EGSolution\AdminEventsCounters\Model\ResourceModel\EgCounter;
use EGSolution\AdminEventsCounters\Model\ResourceModel\EgCounter\Collection;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class Customform extends AbstractModel
{
    protected $_eventPrefix = 'magelearn_customform';
    protected $dataObjectHelper;

    protected $customformDataFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param EgCounterInterfaceFactory $customformDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param EgCounter $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context                   $context,
        Registry                  $registry,
        EgCounterInterfaceFactory $customformDataFactory,
        DataObjectHelper          $dataObjectHelper,
        EgCounter                 $resource,
        Collection                $resourceCollection,
        array                     $data = []
    )
    {
        $this->customformDataFactory = $customformDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     *
     * @return EgCounterInterface
     */
    public function getDataModel()
    {
        $customformData = $this->getData();

        $customformDataObject = $this->customformDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $customformDataObject,
            $customformData,
            EgCounterInterface::class
        );

        return $customformDataObject;
    }
}
