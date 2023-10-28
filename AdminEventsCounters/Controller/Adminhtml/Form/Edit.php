<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml\Form;

use EGSolution\AdminEventsCounters\Api\EventRepositoryInterface;
use EGSolution\AdminEventsCounters\Model\EventFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    protected PageFactory $resultPageFactory;
    protected EventRepositoryInterface $eventRepository;
    protected EventFactory $eventFactory;

    public function __construct(
        Context                  $context,
        PageFactory              $resultPageFactory,
        EventRepositoryInterface $eventRepository,
        EventFactory             $eventFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->eventRepository = $eventRepository;
        $this->eventFactory = $eventFactory;
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->eventFactory->create();

        // 2. Initial checking
        if ($id) {
            $model = $this->eventRepository->getById($id); // Use the repository to load the model by ID
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Counter no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('EGSolution_AdminEventsCounters::event');
        $resultPage->getConfig()->getTitle()->prepend(__('Event'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Counter %1', $model->getId()) : __('New Counter'));
        return $resultPage;
    }
}
