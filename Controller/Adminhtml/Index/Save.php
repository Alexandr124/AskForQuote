<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Vaimo\QuoteModule\Api\Data\QuoteInterface as QuoteInterface;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;

/**
 * Class Save
 * @package Vaimo\QuoteModule\Controller\Adminhtml\Index
 */
class Save extends Base
{
    /** Saving quote information via repository.
     *  NOT USABLE FOR THIS MOMENT. CHECK "SaveCommand" controller
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $isPost = $this->getRequest()->isPost();
        if ($isPost) {
            $model = $this->getModel();
            $formData = $this->getRequest()->getParam('quote_module');
            if (empty($formData)) {
                $formData = $this->getRequest()->getParams();
            }
            if(!empty($formData[QuoteInterface::ID_FIELD])) {
                $id = $formData[QuoteInterface::ID_FIELD];
                $model = $this->repository->getById($id);
            } else {
                unset($formData[QuoteInterface::ID_FIELD]);
            }
            $model->setData($formData);

            try {
                $model = $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('Quote was saved.'));
                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                $this->_getSession()->setFormData(null);
                return $this->redirectToGrid();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Quote wasn\'t saved' ));
            }
            $this->_getSession()->setFormData($formData);
            return (!empty($model->getId())) ?
                $this->_redirect('*/*/edit', ['id' => $model->getId()])
                : $this->_redirect('*/*/edit');
        }
        return $this->doRefererRedirect();
    }

}