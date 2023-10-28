<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Controller\Adminhtml\Form;

use EGSolution\AdminEventsCounters\Api\EventRepositoryInterface;
use EGSolution\AdminEventsCounters\Model\EventFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class InlineEdit extends Action
{
    protected $jsonFactory;
    private Context $context;
    private EventRepositoryInterface $eventRepository;
    private EventFactory $eventFactory;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param EventRepositoryInterface $eventRepository
     * @param EventFactory $eventFactory
     */
    public function __construct(
        Context                  $context,
        JsonFactory              $jsonFactory,
        EventRepositoryInterface $eventRepository,
        EventFactory             $eventFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->context = $context;
        $this->eventRepository = $eventRepository;
        $this->eventFactory = $eventFactory;
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
                        $model = $this->eventRepository->getById($modelId);
                        $model->setData(array_merge($model->getData(), $postItems[$modelId]));
                        $this->eventRepository->save($model);
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
