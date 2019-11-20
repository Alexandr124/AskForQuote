<?php

namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Magento\Framework\Api\SearchCriteriaBuilderFactory;

use Vaimo\Quote\Api\Data\QuoteInterface;
use Vaimo\QuoteModule\Controller\Adminhtml\Base;
use Vaimo\QuoteModule\Model\ArchiveFactory;


/**
 * @property  archiverepository
 */
class MassDelete extends Base
{
    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;


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
//                    $this->repository->deleteById($id);
                    $this->archiveRepository->deleteById($id);
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', count($ids)));
                return $this->redirectToGrid();
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go to grid
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