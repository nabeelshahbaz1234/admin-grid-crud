<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml\Customform;

use EGSolution\AdminEventsCounters\Api\EgCounterRepositoryInterface;
use EGSolution\AdminEventsCounters\Model\EgCounterFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    protected DataPersistorInterface $dataPersistor;
    protected EgCounterRepositoryInterface $egCounterRepository;
    protected Context $context;
    protected EgCounterFactory $egCounterFactory;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param EgCounterRepositoryInterface $egCounterRepository
     * @param EgCounterFactory $egCounterFactory
     */
    public function __construct(
        Context                      $context,
        DataPersistorInterface       $dataPersistor,
        EgCounterRepositoryInterface $egCounterRepository,
        EgCounterFactory             $egCounterFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
        $this->egCounterRepository = $egCounterRepository;
        $this->context = $context;
        $this->egCounterFactory = $egCounterFactory;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();

        if ($data) {
            $id = $this->getRequest()->getParam('id');

            if ($id) {
                // Load the model using the custom repository
                $model = $this->egCounterRepository->getById($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This counter no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                $model = $this->egCounterFactory->create();
            }

            $model->setData($data);

            try {
                // Save the model using the custom repository
                $this->egCounterRepository->save($model);

                $this->messageManager->addSuccessMessage(__('You saved the Counter.'));
                $this->dataPersistor->clear('counter');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the counter.'));
            }

            $this->dataPersistor->set('counter', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
