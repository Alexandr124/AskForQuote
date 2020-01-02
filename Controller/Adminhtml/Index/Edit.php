<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-13
 * Time: 22:43
 */
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Vaimo\QuoteModule\Controller\Adminhtml\Base;

/**
 * Class Edit
 * @package Vaimo\QuoteModule\Controller\Adminhtml\Index
 */
class Edit extends Base
{
    /** Custom Title for the page
     *
     */
    const TITLE = 'Quote Edit';

    /** Setting up 'Edit' layout, with form. Getting data via repository using id parameter.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
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