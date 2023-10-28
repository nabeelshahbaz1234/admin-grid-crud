<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;


abstract class Customform extends Action
{
    const ADMIN_RESOURCE = 'Magelearn_Customform::top_level';
    protected $_coreRegistry;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
    ) {
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Counter'), __('Counter'))
            ->addBreadcrumb(__('Counter'), __('Counter'));
        return $resultPage;
    }
}
