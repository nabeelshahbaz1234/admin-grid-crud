<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml\Form;

use EGSolution\AdminEventsCounters\Api\EventRepositoryInterface;
use EGSolution\AdminEventsCounters\Model\EventFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;

use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    protected EventRepositoryInterface $eventRepository;
    protected EventFactory $eventFactory;

    /**
     * @param Context $context
     * @param EventRepositoryInterface $eventRepository
     * @param EventFactory $eventFactory
     */
    public function __construct(
        Context                  $context,
        EventRepositoryInterface $eventRepository,
        EventFactory             $eventFactory
    ) {
        parent::__construct($context);
        $this->eventRepository = $eventRepository;
        $this->eventFactory = $eventFactory;
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('event_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->eventRepository->getById($id);
                $this->eventRepository->delete($model);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Counter.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Counter to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
