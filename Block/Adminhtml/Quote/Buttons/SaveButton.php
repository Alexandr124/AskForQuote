<?php
namespace Vaimo\QuoteModule\Block\Adminhtml\Quote\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

use Vaimo\QuoteModule\Api\QuoteRepositoryInterface as Repository;

/**
 * Class SaveButton
 * @package Vaimo\QuoteModule\Block\Adminhtml\Quote\Buttons
 */
class SaveButton implements ButtonProviderInterface
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
     * SaveButton constructor.
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
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Quote'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}