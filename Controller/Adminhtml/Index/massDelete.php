<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Magento\Framework\Api\SearchCriteriaBuilderFactory;

use Vaimo\Quote\Api\Data\QuoteInterface;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;
use Magento\Backend\App\Action\Context;

use Vaimo\QuoteModule\Model\ArchiveRepository;
use Vaimo\QuoteModule\Model\QuoteFactory;
use Magento\Framework\View\Result\PageFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

/**
 * Class MassDelete
 * @package Vaimo\QuoteModule\Controller\Adminhtml\Index
 */
class MassDelete extends Base
{
    /**
     * @var SearchCriteriaBuilderFactory
     */

    private $archiveRepository;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Repository $repository
     * @param QuoteFactory $factory
     * @param ArchiveRepository $archiveRepository
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Repository $repository,
        QuoteFactory $factory,
        ArchiveRepository $archiveRepository
    ) {
        parent::__construct($context, $pageFactory, $repository, $factory);
        $this->archiveRepository = $archiveRepository;
    }

    /**
     * @var
     */
    private $searchCriteriaBuilderFactory;

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            throw new \Magento\Framework\Exception\NotFoundException(__('Elements not found.'));
        }
        $ids = $this->getRequest()->getParam('selected');
        $excluded = $this->getRequest()->getParam('excluded');
        if($ids) {
            try {
                foreach ($ids as $id) {
                    $this->archiveRepository->deleteById($id);
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', count($ids)));
                return $this->redirectToGrid();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $this->redirectToGrid();
            }
        } elseif ($excluded) {
            $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
            $searchCriteria = $searchCriteriaBuilder->addFilter(QuoteInterface::ID_FIELD, $excluded, 'nin')->create();
            $listOrders = $this->archiveRepository->getList($searchCriteria)->getItems();
            foreach ($listOrders as $order) {
                $this->archiveRepository->delete($order);
            }
        }
        return $this->redirectToGrid();
    }
}