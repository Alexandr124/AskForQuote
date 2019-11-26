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
    protected $context;
    protected $repository;

    public function __construct(
        Context $context,
        Repository $repository
    ) {
        $this->context = $context;
        $this->repository = $repository;
    }


    public function getUrl($route = '', $params = [])
    {
        $m = $this->context->getUrlBuilder()->getUrl($route, $params);
        return $m ;
    }

    public function getButtonData()
    {
        return [
            'label' => __('Reply block'),
            'class' => 'send primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'send']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}