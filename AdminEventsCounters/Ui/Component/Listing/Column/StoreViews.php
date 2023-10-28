<?php

namespace EGSolution\AdminEventsCounters\Ui\Component\Listing\Column;

use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class StoreViews extends Column
{

    /**
     * @var CountryInformationAcquirerInterface
     */
    protected $countryInformation;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CountryInformationAcquirerInterface $countryInformation
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface                    $context,
        UiComponentFactory                  $uiComponentFactory,
        CountryInformationAcquirerInterface $countryInformation,
        array                               $components = [],
        array                               $data = []
    )
    {
        $this->countryInformation = $countryInformation;
        parent::__construct($context, $uiComponentFactory, $components, $data);
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
            foreach ($dataSource['data']['items'] as & $item) {
                $countryNames = [];
                $countryCodes = [];
                if (!empty($item[$fieldName])) {
                    $countryCodes = explode(',', $item[$fieldName]);
                }
                foreach ($countryCodes as $codes) {
                    $country = $this->countryInformation->getCountryInfo($codes);
                    $countryNames[] = $country->getFullNameLocale();
                }
                $item[$fieldName] = implode(',', $countryNames);
            }
        }

        return $dataSource;
    }
}
