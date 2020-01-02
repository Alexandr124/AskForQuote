<?php
namespace Vaimo\QuoteModule\Controller\Frontend;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

use Vaimo\QuoteModule\Api\Data\QuoteInterface;
use Vaimo\QuoteModule\Model\QuoteRepository;
use Vaimo\QuoteModule\Model\QuoteFactory;

/**
 * Class Save
 * @package Vaimo\QuoteModule\Controller\Frontend
 */
class Save extends Action
{
    /**
     * @var QuoteRepository
     */
    private $repository;
    /**
     * @var QuoteFactory
     */
    private $quoteFactory;

    private $storemanager;

    /**
     * Save constructor.
     * @param QuoteFactory $quoteFactory
     * @param QuoteRepository $quoteRepository
     * @param Context $context
     */
    public function __construct(QuoteFactory $quoteFactory,
                                QuoteRepository $quoteRepository,
                                Context $context,
                                \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->repository = $quoteRepository;
        $this->quoteFactory = $quoteFactory;
        parent::__construct($context);
        $this->storemanager = $storeManager;
    }

    /** Quote form font
     * Fields validation enabled
     *
     * TODO Redirect to the lastPage is not working.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $formData = $this->getRequest()->getParams();
        $email = $this->getRequest()->getParam('customer_email');

        if(!$this->validation($formData)){
            $this->messageManager->addErrorMessage(__('Check out please data in fields'));
            return $this->redirectToLastPage();
        } else {
            try {
                $this->repository->save($this->quoteFactory->create()->setData($formData));
                $this->messageManager->addSuccessMessage(__('Quote was sent'));

                $this->_eventManager->dispatch('ask_for_quote_form_sent', ['findMail' => $email]);

            } catch (\Exception $e) {
                if ($e->getMessage()) {
                    $this->messageManager->addWarningMessage($e->getMessage());
                } else {
                    $this->messageManager->addErrorMessage(__('Quote wasn\'t saved, please try again'));
                }
            }
        }
        return $this->redirectToLastPage();

    }

    /**
     * @param $formData
     * @return bool
     */
    private function validation($formData)
    {
        if (!$formData[QuoteInterface::CUSTOMER_FIRST_NAME] ||
            !$formData[QuoteInterface::MAIL] ||
            !$formData[QuoteInterface::COMMENT]) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    private function redirectToLastPage()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirectUrl= $this->storemanager->getStore()->getBaseURL();

        $resultRedirect->setPath($redirectUrl);
        return $resultRedirect;
    }
}