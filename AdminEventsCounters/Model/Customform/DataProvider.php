<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Model\Customform;

use EGSolution\AdminEventsCounters\Model\ResourceModel\EgCounter\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var
     */
    protected $loadedData;
    /**
     * @var
     */
    protected $collection;
    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;
    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;
    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface $storeManager
     * @param Filesystem $filesystem
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->filesystem = $filesystem;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $itemData = $model->getData();
            $this->loadedData[$model->getId()] = $itemData;
        }
        $data = $this->dataPersistor->get('counter');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('counter');
        }

        return $this->loadedData;
    }
}
