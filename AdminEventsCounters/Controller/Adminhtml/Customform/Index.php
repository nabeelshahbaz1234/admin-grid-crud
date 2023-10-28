<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml\Customform;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'EGSolution_AdminEventsCounters::key2';
    protected PageFactory $resultPageFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context        $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::ADMIN_RESOURCE);
        $resultPage->addBreadcrumb(__('Customer Data'), __('Customer Data'));
        $resultPage->addBreadcrumb(__('Customer Data'), __('Customer Data'));
        $resultPage->getConfig()->getTitle()->prepend(__("Counter EgSolution"));
        return $resultPage;
    }
}
