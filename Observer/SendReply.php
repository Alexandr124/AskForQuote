<?php
namespace Vaimo\QuoteModule\Observer;

use Magento\Framework\Event\ObserverInterface;
use Vaimo\QuoteModule\Helper\Email;
use Vaimo\QuoteModule\Model\QuoteFactory;

class SendReply implements ObserverInterface
{
    /**
     * @var Email
     */
    private $helperEmail;
    /**
     * @var QuoteFactory
     */
    protected $modelFactory;

    /**
     * SendReply constructor.
     * @param Email $helperEmail
     * @param QuoteFactory $factory
     */
    public function __construct(
        Email $helperEmail,
        QuoteFactory $factory
    ) {
        $this->helperEmail = $helperEmail;
        $this->modelFactory = $factory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return bool|void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $formData[] = $observer->getData('email');
        $formData[] = $observer->getData('reply');
        $status = $observer->getData('status');

        $this->helperEmail->sendEmail($formData);
    }
}