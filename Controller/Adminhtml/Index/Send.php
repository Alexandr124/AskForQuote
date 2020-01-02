<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;

use Psr\Log\LoggerInterface;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;
use Vaimo\QuoteModule\Model\QuoteFactory;
use Magento\Framework\View\Result\PageFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

/**
 * Class Send
 * @package Vaimo\QuoteModule\Controller\Adminhtml\Index
 */
class Send extends Base
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Send constructor.
     * @param LoggerInterface $logger
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Repository $repository
     * @param QuoteFactory $factory
     */
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

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
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