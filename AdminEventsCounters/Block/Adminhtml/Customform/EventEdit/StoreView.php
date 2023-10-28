<?php

namespace EGSolution\AdminEventsCounters\Block\Adminhtml\Customform\EventEditt;

use Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;

class StoreView extends Generic
{
    protected $systemStore;

    public function __construct(
        Store       $systemStore,
        Context     $context,
        Registry    $registry,
        FormFactory $formFactory,
        array       $data = []
    )
    {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->systemStore = $systemStore;
    }

    /**
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset(
            'field_set_id',
            ['legend' => __('form title')]
        );

        $field = $fieldset->addField(
            'store_id',
            'select',
            [
                'label' => __('Store View'),
                'title' => __('Store View'),
                'name' => 'store_id',
                'value' => $model->getStoreId(),
                'values' => $this->systemStore->getStoreValuesForForm(false, true)
//                set first argument true and second to false to add blank option which value is blank
//                set second argument true to add "All Store Views" option which value is 0
            ]
        );
        $renderer = $this->getLayout()->createBlock(
            Element::class
        );
        $field->setRenderer($renderer);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
