<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-07
 * Time: 11:50
 */
namespace Vaimo\QuoteModule\DataProvider;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class BaseQuoteProvider/ Used while edit & reply
 * @package Vaimo\QuoteModule\DataProvider
 */
class BaseQuoteProvider extends AbstractDataProvider
{
    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;

    public function __construct(CollectionFactory $collectionFactory,
                                SessionManagerInterface $sessionManager,
                                $name,
                                $primaryFieldName,
                                $requestFieldName,
                                array $meta = [], array
                                $data = [])
    {
        // $this->collection      =  $collectionFactory->create();
        $this->sessionManager  =  $sessionManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    /**
     * @return array
     */
    public function getData()
    {
        $model = $this->sessionManager->getCurrentQuoteModel();
        $this->sessionManager->setCurrentQuoteModel(null);
        if($model!=null) {
            return [$model->getId()=> $model->getData()];
        } else return [];
    }

    /**
     * @param \Magento\Framework\Api\Filter $filter
     * @return mixed|void|null
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        return null;
    }
}