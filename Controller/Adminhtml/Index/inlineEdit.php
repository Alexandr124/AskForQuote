<?php

namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Psr\Log\LoggerInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Registry;

use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as  Repository;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;
use Vaimo\QuoteModule\Model\ArchiveRepository;
use Vaimo\QuoteModule\Model\QuoteFactory;

class InlineEdit extends Base
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;
    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchBuilderFactory;
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;
    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    public function __construct(FilterGroupBuilder $filterGroupBuilder,
                                ResourceConnection $resource,
                                Repository $repository,
                                ArchiveRepository $archiveRepository,
                                FilterBuilder $filterBuilder,
                                Registry $registry,
                                SessionManagerInterface $sessionManager,
                                LoggerInterface $logger,
                                SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
                                JsonFactory $jsonFactory,
                                QuoteFactory $quoteFactory,
                                PageFactory $pageFactory,
                                Context $context
    ) {
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->archiveRepository = $archiveRepository;
        $this->searchBuilderFactory = $searchCriteriaBuilderFactory;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($resource, $context, $registry, $pageFactory, $sessionManager, $repository, $archiveRepository, $quoteFactory, $logger  );
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $quoteId) {
                    $quote = $this->repository->getById($quoteId);
                    try {
                        $quote->setData(array_merge($quote->getData(), $postItems[$quoteId]));
                        $this->repository->save($quote);
                    } catch (\Exception $e) {
                        $messages[] = __($e->getMessage());
                        $error = true;
                    }
                }
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}