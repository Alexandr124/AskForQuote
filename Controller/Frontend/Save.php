<?php

namespace Vaimo\QuoteModule\Controller\Frontend;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

use Vaimo\QuoteModule\Model\QuoteRepository;
use Vaimo\QuoteModule\Model\QuoteFactory;
use Vaimo\QuoteModule\Api\Data\QuoteInterface;

class Save extends Action
{
    private $repository;
    private $quoteFactory;
    public function __construct(QuoteFactory $quoteFactory,
                                QuoteRepository $quoteRepository,
                                Context $context)
    {
        $this->repository = $quoteRepository;
        $this->quoteFactory = $quoteFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $formData = $this->getRequest()->getParams();
        try{
            $this->repository->save($this->quoteFactory->create()->setData($formData));
            $this->messageManager->addSuccessMessage(__('Quote has been saved.'));
        } catch (\Exception $e){
            if ($e->getMessage()) {
                $this->messageManager->addWarningMessage($e->getMessage());
            } else {
                $this->messageManager->addErrorMessage(__('Quote wasn\'t saved, please try again'));
            }
        }

    }
}