<?php
namespace Vaimo\QuoteModule\Observer;

use Magento\Framework\Event\ObserverInterface;
use Vaimo\QuoteModule\Helper\Email;
use Vaimo\QuoteModule\Model\QuoteFactory;

class SendReply implements ObserverInterface
{
    private $helperEmail;
    protected $modelFactory;

    public function __construct(
        Email $helperEmail,
        QuoteFactory $factory
    ) {
        $this->helperEmail = $helperEmail;
        $this->modelFactory = $factory;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $formData[] = $observer->getData('email');
        $formData[] = $observer->getData('reply');

//        $model = $this->modelFactory->create();
//        $model->setData($formData->getParams());
//        $temp = $formData->getRequest()->getParam('customer_email');
//        $email = $model->getMail();

        return $this->helperEmail->sendEmail($formData);
    }
}