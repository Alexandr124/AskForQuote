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
class SaveButton implements ButtonProviderInterface
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

    public function getQuoteId()
    {
        try {
            return $this->repository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

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