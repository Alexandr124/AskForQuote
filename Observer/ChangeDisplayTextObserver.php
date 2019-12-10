<?php

namespace Vaimo\QuoteModule\Observer;

class ChangeDisplayTextObserver implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $displayText = $observer->getData('mp_text');
        $displayText->setText('Execute event successfully.');

        return $this;
    }
}

//I'm not using this one.  Just let it be, like an example.