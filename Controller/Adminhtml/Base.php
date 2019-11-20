<?php

namespace Vaimo\QuoteModule\Controller\Adminhtml;

use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Session\SessionManagerInterface;

use Vaimo\QuoteModule\Model\QuoteFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;
use Vaimo\QuoteModule\Model\ArchiveRepository;

abstract class Base extends Action
{
    const ACL_RESOURCE          = 'Vaimo_QuoteModule::all';
    const MENU_ITEM             = 'Vaimo_QuoteModule::all';
    const PAGE_TITLE            = 'Quote module';
    const QUERY_PARAM_ID        = 'id';

    protected $_resource;
    protected $registry;
    protected $pageFactory;
    protected $modelFactory;
    protected $model;
    /** @var Page */
    protected $resultPage;
    protected $sessionManager;
    protected $repository;
    protected $archiveRepository;
    protected $jsonFactory;

    protected $logger;


    public function __construct(
        ResourceConnection $resource,
        Context $context,
        Registry $registry,
        PageFactory $pageFactory,
        SessionManagerInterface $sessionManager,
        Repository $repository,
        ArchiveRepository $archiveRepository,
        QuoteFactory $factory,
        LoggerInterface $logger,
        JsonFactory $jsonFactory
    ){
        $this->_resource      = $resource;
        $this->registry       = $registry;
        $this->pageFactory    = $pageFactory;
        $this->sessionManager  = $sessionManager;
        $this->repository     = $repository;
        $this->archiveRepository = $archiveRepository;
        $this->modelFactory   = $factory;
        $this->logger         = $logger;
        $this->jsonFactory = $jsonFactory;
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