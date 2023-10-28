<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml\Customform;

use EGSolution\AdminEventsCounters\Api\EgCounterRepositoryInterface;
use EGSolution\AdminEventsCounters\Model\EgCounterFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \EGSolution\AdminEventsCounters\Controller\Adminhtml\Customform
{
    protected PageFactory $resultPageFactory;
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
        PageFactory                  $resultPageFactory,
        EgCounterRepositoryInterface $egCounterRepository,
        EgCounterFactory             $egCounterFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
        $this->egCounterRepository = $egCounterRepository;
        $this->egCounterFactory = $egCounterFactory;
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->egCounterFactory->create();

        // 2. Initial checking
        if ($id) {
            $model = $this->egCounterRepository->getById($id); // Use the repository to load the model by ID
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
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Counter') : __('New Counter'),
            $id ? __('Edit Counter') : __('New Counter')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Counter'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Counter %1', $model->getId()) : __('New Counter'));
        return $resultPage;
    }
}
