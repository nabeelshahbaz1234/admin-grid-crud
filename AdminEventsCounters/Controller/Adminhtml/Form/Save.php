<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml\Form;


use EGSolution\AdminEventsCounters\Api\EventRepositoryInterface;
use EGSolution\AdminEventsCounters\Model\EventFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    protected DataPersistorInterface $dataPersistor;
    protected Context $context;
    protected EventRepositoryInterface $eventRepository;
    protected EventFactory $eventFactory;

    public function __construct(
        Context                      $context,
        DataPersistorInterface       $dataPersistor,
        EventRepositoryInterface $eventRepository,
        EventFactory             $eventFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);

        $this->context = $context;
        $this->eventRepository = $eventRepository;
        $this->eventFactory = $eventFactory;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParams();

        if ($data) {
            $id = $this->getRequest()->getParam('id');

            if ($id) {
                // Load the model using the custom repository
                $model = $this->eventRepository->getById($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This counter no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                $model = $this->eventFactory->create();
            }
            if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                $data['image'] =$data['image'][0]['name'];
                $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                    'Magelearn\Customform\CustomformImageUpload'
                );
                $this->imageUploader->moveFileFromTmp($data['image']);
            } elseif (isset($data['image'][0]['name']) && !isset($data['image'][0]['tmp_name'])) {
                $data['image'] = $data['image'][0]['name'];
            } else {
                $data['image'] = null;
            }

            $model->setData($data);

            try {
                // Save the model using the custom repository
                $this->eventRepository->save($model);

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
