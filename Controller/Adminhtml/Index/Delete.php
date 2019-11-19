<?php

namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;
use Vaimo\QuoteModule\Controller\Adminhtml\Base as BaseLink;
use Vaimo\QuoteModule\Api\Data\QuoteInterface;


class Delete extends Baselink
{

    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);

        if (!empty($id)) {
            try {

                $temp = $this->repository->getById($id);
//                unset($temp[QuoteInterface::ID_FIELD]);
                $this->_eventManager->dispatch('quote_was_deleted', ['deletedModel' => $temp]);

                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('Quote was deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(_('Link can\'t be deleted'));
                return $this->doRefererRedirect();
            }
        } else {
            $this->logger->error(
                sprintf("Require parameter `%s` is missing", static::QUERY_PARAM_ID) // hz chto eto
            );
        }
        return $this->redirectToGrid();
    }
}