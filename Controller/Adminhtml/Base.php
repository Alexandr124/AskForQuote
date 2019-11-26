<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

use Vaimo\QuoteModule\Model\QuoteFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

abstract class Base extends Action
{
    const ACL_RESOURCE          = 'Vaimo_QuoteModule::all';
    const MENU_ITEM             = 'Vaimo_QuoteModule::all';
    const PAGE_TITLE            = 'Quote module';
    const QUERY_PARAM_ID        = 'id';

    protected $pageFactory;
    protected $modelFactory;
    protected $model;
    /** @var Page */
    protected $resultPage;
    protected $repository;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Repository $repository,
        QuoteFactory $factory
    ){
        $this->pageFactory    = $pageFactory;
        $this->repository     = $repository;
        $this->modelFactory   = $factory;

        parent::__construct($context);
    }

    public function execute()
    {
        $this->_setPageData();
        return $this->resultPage;
    }

    protected function _isAllowed()
    {
        $result = parent::_isAllowed();
        $result = $result && $this->_authorization->isAllowed(static::ACL_RESOURCE);
        return $result;
    }

    protected function _getResultPage()
    {
        if (null === $this->resultPage) {
            $this->resultPage = $this->pageFactory->create();
        }
        return $this->resultPage;
    }

    protected function _setPageData()
    {
        $resultPage = $this->_getResultPage();
        $resultPage->getConfig()->getTitle()->prepend((__(static::PAGE_TITLE)));

        return $this;
    }

    protected function getModel()
    {
        if (null === $this->model) {
            $this->model = $this->modelFactory->create();
        }
        return $this->model;
    }

    protected function doRefererRedirect()
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->_redirect->getRefererUrl());
        return $redirect;
    }

    protected function redirectToGrid()
    {
        return $this->_redirect('*/*/index');
    }
}