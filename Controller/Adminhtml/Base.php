<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

use Vaimo\QuoteModule\Model\QuoteFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

/**
 * Class Base
 * @package Vaimo\QuoteModule\Controller\Adminhtml
 */
abstract class Base extends Action
{
    /**
     *
     */
    const ACL_RESOURCE          = 'Vaimo_QuoteModule::all';
    /**
     *
     */
    const MENU_ITEM             = 'Vaimo_QuoteModule::all';
    /**
     *
     */
    const PAGE_TITLE            = 'Quote module';
    /**
     *
     */
    const QUERY_PARAM_ID        = 'id';

    /**
     * @var PageFactory
     */
    protected $pageFactory;
    /**
     * @var QuoteFactory
     */
    protected $modelFactory;
    /**
     * @var
     */
    protected $model;
    /** @var Page */
    protected $resultPage;
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Base constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Repository $repository
     * @param QuoteFactory $factory
     */
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

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|Page
     */
    public function execute()
    {
        $this->_setPageData();
        return $this->resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        $result = parent::_isAllowed();
        $result = $result && $this->_authorization->isAllowed(static::ACL_RESOURCE);
        return $result;
    }

    /**
     * @return Page
     */
    protected function _getResultPage()
    {
        if (null === $this->resultPage) {
            $this->resultPage = $this->pageFactory->create();
        }
        return $this->resultPage;
    }

    /**
     * @return $this
     */
    protected function _setPageData()
    {
        $resultPage = $this->_getResultPage();
        $resultPage->getConfig()->getTitle()->prepend((__(static::PAGE_TITLE)));

        return $this;
    }

    /**Getting quote model via QuoteFactory
     * @return mixed
     */
    protected function getModel()
    {
        if (null === $this->model) {
            $this->model = $this->modelFactory->create();
        }
        return $this->model;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    protected function doRefererRedirect()
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->_redirect->getRefererUrl());
        return $redirect;
    }

    /**Redirect to main page(grid) of the custom module
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function redirectToGrid()
    {
        return $this->_redirect('*/*/index');
    }
}