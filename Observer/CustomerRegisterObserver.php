<?php
namespace Vaimo\QuoteModule\Observer;

use Magento\Framework\Event\ObserverInterface;
use Vaimo\QuoteModule\Helper\Email;


class CustomerRegisterObserver implements ObserverInterface
{
    private $helperEmail;

    public function __construct(
        Email $helperEmail
    ) {
        $this->helperEmail = $helperEmail;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $formData = $observer->getData('findMail');
        return $this->helperEmail->sendEmail($formData);
    }
}