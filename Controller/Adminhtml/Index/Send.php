<?php

namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;


class Send extends Base
{

    public function execute()
    {


        $isPost = $this->getRequest()->isPost();

        if ($isPost) {
            $model = $this->getModel();
            $formData = $this->getRequest()->getParams();

            $model->setData($formData);

            $email = $this->getRequest()->getParam('customer_email');
            $reply = $this->getRequest()->getParam('reply');

            $this->_eventManager->dispatch('quote_reply_sent', ['email' => $email, 'reply' => $reply ]);
        }
        return $this->doRefererRedirect();
    }
}