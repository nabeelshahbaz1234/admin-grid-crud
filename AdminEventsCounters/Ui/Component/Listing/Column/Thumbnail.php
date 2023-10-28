<?php

namespace EGSolution\AdminEventsCounters\Ui\Component\Listing\Column;

use Magento\Catalog\Helper\Image;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column
{
    const NAME = 'image';
    const ALT_FIELD = 'name';
    protected $storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Image $imageHelper
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface      $context,
        UiComponentFactory    $uiComponentFactory,
        StoreManagerInterface $storeManager,
        array                 $components = [],
        array                 $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $path = $this->storeManager->getStore()->getBaseUrl(
                UrlInterface::URL_TYPE_MEDIA
            );
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['image']) {
                    $item[$fieldName . '_src'] = $path . $item['image'];
                    $item[$fieldName . '_alt'] = $item['first_name'] . ' ' . $item['last_name'];
                    $item[$fieldName . '_orig_src'] = $path . $item['image'];
                } else {
                    // please place your placeholder image at pub/media/egsolution/AdminEventsCounters/placeholder/placeholder.jpg
                    $item[$fieldName . '_src'] = $path . 'egsolution\AdminEventsCounters/placeholder/placeholder.jpg';
                    $item[$fieldName . '_alt'] = 'Place Holder';
                    $item[$fieldName . '_orig_src'] = $path . 'egsolution\AdminEventsCounters/placeholder/placeholder.jpg';
                }
            }
        }

        return $dataSource;
    }
}
