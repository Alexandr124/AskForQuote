<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Vaimo\QuoteModule\Controller\Adminhtml\Base as BaseLink;
use Vaimo\QuoteModule\Api\Data\QuoteInterface;
use Vaimo\QuoteModule\Model\Command\DeleteByPath;
use Vaimo\QuoteModule\Model\QuoteFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

class DeleteCommand extends BaseLink
{
    protected $detelePath;

    public function __construct(
        DeleteByPath $detelePath,
        Context $context,
        PageFactory $pageFactory,
        Repository $repository,
        QuoteFactory $factory
    ) {
        $this->detelePath = $detelePath;
        parent::__construct($context, $pageFactory, $repository, $factory);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);

        if (!empty($id)) {
            try {

                $temp = $this->repository->getById($id);

                $this->detelePath->execute($id);
                $this->messageManager->addSuccessMessage(__('Quote was deleted.'));

                $this->_eventManager->dispatch('quote_was_deleted', ['deletedModel' => $temp]);

            } catch (\Exception $e) {
                return $this->doRefererRedirect();
            }
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t find an item to delete.'));
        }
        return $this->redirectToGrid();
    }
}