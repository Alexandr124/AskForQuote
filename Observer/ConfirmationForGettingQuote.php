<?php
namespace Vaimo\QuoteModule\Observer;

use Magento\Framework\Event\ObserverInterface;
use Vaimo\QuoteModule\Helper\Email;


/**
 * Sending an automatic email after getting queue from customer
 *
 * Class ConfirmationForGettingQuote
 * @package Vaimo\QuoteModule\Observer
 */
class ConfirmationForGettingQuote implements ObserverInterface
{
    /**
     * @var Email
     */
    private $helperEmail;

    /**
     * ConfirmationForGettingQuote constructor.
     * @param Email $helperEmail
     */
    public function __construct(
        Email $helperEmail
    ) {
        $this->helperEmail = $helperEmail;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return bool|void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $formData[] = $observer->getData('findMail');
        $formData[] ="";

      $this->helperEmail->sendEmail($formData);
    }
}