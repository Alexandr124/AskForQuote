<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Vaimo\QuoteModule\Api\Data\QuoteInterface as QuoteInterface;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;
use Vaimo\QuoteModule\Model\Command\SaveByPath;
use Vaimo\QuoteModule\Model\QuoteFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

/**
 * Class SaveCommand
 * @package Vaimo\QuoteModule\Controller\Adminhtml\Index
 */
class SaveCommand extends Base
{
    /**
     * @var SaveByPath
     */
    protected $saveByPath;

    /**
     * SaveCommand constructor.
     * @param SaveByPath $saveByPath
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Repository $repository
     * @param QuoteFactory $factory
     */
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

    /**
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