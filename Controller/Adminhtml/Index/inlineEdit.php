<?php

namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;


use Magento\Framework\Controller\Result\JsonFactory;

use Vaimo\QuoteModule\Model\QuoteFactory;
use Magento\Framework\View\Result\PageFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;

/**
 * Class InlineEdit
 * @package Vaimo\QuoteModule\Controller\Adminhtml\Index
 */
class InlineEdit extends Base
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Repository $repository
     * @param QuoteFactory $factory
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Repository $repository,
        QuoteFactory $factory,
        JsonFactory $jsonFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context, $pageFactory, $repository, $factory );
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $resultJson = $this->jsonFactory->create();

        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $quoteId) {
                    $quote = $this->repository->getById($quoteId);
                    try {
                        $quote->setData(array_merge($quote->getData(), $postItems[$quoteId]));
                        $this->repository->save($quote);
                    } catch (\Exception $e) {
                        $messages[] = __($e->getMessage());
                        $error = true;
                    }
                }
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}