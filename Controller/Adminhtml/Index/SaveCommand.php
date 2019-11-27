<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Vaimo\QuoteModule\Api\Data\QuoteInterface as QuoteInterface;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;
use Vaimo\QuoteModule\Model\Command\SaveByPath;
use Vaimo\QuoteModule\Model\QuoteFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

class SaveCommand extends Base
{
    protected $saveByPath;

    public function __construct(
        SaveByPath $saveByPath,
        Context $context,
        PageFactory $pageFactory,
        Repository $repository,
        QuoteFactory $factory
    ) {
        $this->saveByPath = $saveByPath;
        parent::__construct($context, $pageFactory, $repository, $factory);
    }

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

//                $model = $this->repository->save($model);
                $this->saveByPath->execute($model);

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