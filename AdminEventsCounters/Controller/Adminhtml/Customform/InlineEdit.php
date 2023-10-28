<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml\Customform;

use EGSolution\AdminEventsCounters\Api\EgCounterRepositoryInterface;
use EGSolution\AdminEventsCounters\Model\EgCounterFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class InlineEdit extends Action
{
    protected $jsonFactory;
    private EgCounterRepositoryInterface $egCounterRepository;
    private EgCounterFactory $egCounterFactory;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context              $context,
        JsonFactory $jsonFactory,
        EgCounterRepositoryInterface $egCounterRepository,
        EgCounterFactory             $egCounterFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->egCounterRepository = $egCounterRepository;
        $this->egCounterFactory = $egCounterFactory;
    }

    /**
     * Inline edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelId) {
                    try {
                        $model = $this->egCounterRepository->getById($modelId);
                        $model->setData(array_merge($model->getData(), $postItems[$modelId]));
                        $this->egCounterRepository->save($model);
                    } catch (LocalizedException $e) {
                        $messages[] = "[Customform ID: {$modelId}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error,
        ]);
    }
}
