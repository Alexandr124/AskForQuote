<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;

use Psr\Log\LoggerInterface;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;
use Vaimo\QuoteModule\Model\QuoteFactory;
use Magento\Framework\View\Result\PageFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

class Send extends Base
{
    private $logger;
    public function __construct(
        LoggerInterface $logger,
        Context $context,
        PageFactory $pageFactory,
        Repository $repository,
        QuoteFactory $factory
    ) {
        $this->logger = $logger;
        parent::__construct($context, $pageFactory, $repository, $factory);
    }
    public function execute()
    {
        $isPost = $this->getRequest()->isPost();

        if ($isPost) {
            $model = $this->getModel();
            $formData = $this->getRequest()->getParams();

            $model->setData($formData);

            $email = $this->getRequest()->getParam('customer_email');
            $reply = $this->getRequest()->getParam('reply');
            $status = $this->getRequest()->getParam('quote_status');

            try {

                $this->_eventManager->dispatch('quote_reply_sent', ['email' => $email, 'reply' => $reply, 'status' => $status ]);
                $quote = $this->repository->getById($this->getRequest()->getParam('quote_id'));
                $quote->setQuoteStatus('open');
                $this->repository->save($quote);

            } catch (\Exception $e) {
                $this->logger->debug($e->getMessage());
            }

        }
        return $this->redirectToGrid();
    }
}