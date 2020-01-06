<?php
namespace Vaimo\QuoteModule\Block\Adminhtml\Quote\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

/**
 * Class GenericButton
 * @package Mytest\Elevator\Block\Adminhtml\Elevator\Buttons
 */
class SendReplyButton implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * SendReplyButton constructor.
     * @param Context $context
     * @param Repository $repository
     */
    public function __construct(
        Context $context,
        Repository $repository
    ) {
        $this->context = $context;
        $this->repository = $repository;
    }


    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        $m = $this->context->getUrlBuilder()->getUrl($route, $params);
        return $m ;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reply'),
            'class' => 'send primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'send']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}