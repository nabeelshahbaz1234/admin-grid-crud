<?php
declare(strict_types=1);
namespace EGSolution\AdminEventsCounters\Model;

use EGSolution\AdminEventsCounters\Api\Data\EgCounterInterface;
use EGSolution\AdminEventsCounters\Api\EgCounterRepositoryInterface;
use EGSolution\AdminEventsCounters\Model\ResourceModel\EgCounter as EgCounterResource;
use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @class EgCounterRepository
 */
class EgCounterRepository implements EgCounterRepositoryInterface
{
    /**
     * @var EgCounterFactory
     */
    protected EgCounterFactory $egCounterFactory;
    /**
     * @var EgCounterResource
     */
    protected EgCounterResource $egCounterResource;

    /**
     * @param EgCounterFactory $egCounterFactory
     * @param EgCounterResource $egCounterResource
     */
    public function __construct(
        EgCounterFactory  $egCounterFactory,
        EgCounterResource $egCounterResource
    ) {
        $this->egCounterFactory = $egCounterFactory;
        $this->egCounterResource = $egCounterResource;
    }

    /**
     * @param EgCounterInterface $egCounter
     * @return void
     * @throws AlreadyExistsException
     */
    public function save(EgCounterInterface $egCounter): void
    {
        $this->egCounterResource->save($egCounter);
    }

    /**
     * @param $egCounterId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($egCounterId): mixed
    {
        $egCounter = $this->egCounterFactory->create();
        $this->egCounterResource->load($egCounter, $egCounterId);
        if (!$egCounter->getId()) {
            throw new NoSuchEntityException(__('The eg_counter with ID %1 does not exist.', $egCounterId));
        }
        return $egCounter;
    }

    /**
     * @throws Exception
     */
    public function delete(EgCounterInterface $egCounter): void
    {
        $this->egCounterResource->delete($egCounter);
    }

    /**
     * @throws NoSuchEntityException
     * @throws Exception
     */
    public function deleteById($egCounterId): void
    {
        $egCounter = $this->getById($egCounterId);
        $this->delete($egCounter);
    }
}
