<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-13
 * Time: 22:43
 */
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Vaimo\QuoteModule\Controller\Adminhtml\Base;

class Reply extends Base
{
    const TITLE = 'Reply';

    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);
        if (!empty($id)) {
            try {
                $model = $this->repository->getById($id);
                $this->_getSession()->setCurrentQuoteModel($model);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('Entity with id %1 not found', $id));
                return $this->redirectToGrid();
            }
        } else {
            if($this->_getSession()->getFormData()){
                $model = $this->getModel();
                $model->setData($this->_getSession()->getFormData());
                $this->_getSession()->setFormData(null);
                $this->_getSession()->setCurrentQuoteModel($model);
            }
        }
        return parent::execute();
    }
}