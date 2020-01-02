<?php
namespace Vaimo\QuoteModule\Controller\Adminhtml\Index;

use Vaimo\QuoteModule\Controller\Adminhtml\Base as BaseLink;
use Vaimo\QuoteModule\Api\Data\QuoteInterface;
use Vaimo\QuoteModule\Model\Command\DeleteByPath;
use Vaimo\QuoteModule\Model\Command\GetById;
use Vaimo\QuoteModule\Model\QuoteFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

/**
 * Class DeleteCommand
 * @package Vaimo\QuoteModule\Controller\Adminhtml\Index
 */
class DeleteCommand extends BaseLink
{
    /**
     * @var DeleteByPath
     */
    protected $detelePath;
    /**
     * @var GetById
     */
    protected $getById;

    /**
     * DeleteCommand constructor.
     * @param Context $context
     * @param DeleteByPath $detelePath
     * @param PageFactory $pageFactory
     * @param Repository $repository
     * @param QuoteFactory $factory
     * @param GetById $getById
     */
    public function __construct(
        Context $context,
        DeleteByPath $detelePath,
        PageFactory $pageFactory,
        Repository $repository,
        QuoteFactory $factory,
        GetById $getById
    ) {
        parent::__construct($context, $pageFactory, $repository, $factory);
        $this->detelePath = $detelePath;
        $this->getById = $getById;
    }

    /** Delete via command. Catching an event and saving deleted quote to the Archive
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);

        if (!empty($id)) {
            try {

                $temp = $this->getById->execute($id);

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