<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml\Customform;

use EGSolution\AdminEventsCounters\Api\EgCounterRepositoryInterface;
use EGSolution\AdminEventsCounters\Controller\Adminhtml\Customform;
use EGSolution\AdminEventsCounters\Model\EgCounterFactory;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Customform
{
    private EgCounterRepositoryInterface $egCounterRepository;
    private EgCounterFactory $egCounterFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param EgCounterRepositoryInterface $egCounterRepository
     * @param EgCounterFactory $egCounterFactory
     */
    public function __construct(
        Context                      $context,
        Registry                     $coreRegistry,
        EgCounterRepositoryInterface $egCounterRepository,
        EgCounterFactory             $egCounterFactory
    ) {
        parent::__construct($context, $coreRegistry);
        $this->egCounterRepository = $egCounterRepository;
        $this->egCounterFactory = $egCounterFactory;
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
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->egCounterRepository->getById($id);
                $this->egCounterRepository->delete($model);
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
