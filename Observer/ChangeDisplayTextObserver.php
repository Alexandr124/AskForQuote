<?php

namespace Vaimo\QuoteModule\Observer;

/**
 * Class ChangeDisplayTextObserver
 * @package Vaimo\QuoteModule\Observer
 */
class ChangeDisplayTextObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this|void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $displayText = $observer->getData('mp_text');
        $displayText->setText('Execute event successfully.');

        return $this;
    }
}

//I'm not using this one.  Just let it be, like an example.