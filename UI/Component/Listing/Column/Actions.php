<?php

namespace Vaimo\QuoteModule\UI\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    const URL_PATH_EDIT = 'quote_module/index/edit';
    const URL_PATH_DELETE = 'quote_module/index/delete';
    const URL_PATH_REPLY = 'quote_module/index/reply';

    const URL_PATH_DELETE_NEW = 'quote_module/index/deletecommand';

    const IDENTIFIRE = 'quote_id';

    protected $urlBuilder;
    private $editUrl;
    /**
     * @param ContextInterface      $context
     * @param UiComponentFactory    $uiComponentFactory
     * @param UrlInterface          $urlBuilder
     * @param array                 $components
     * @param array                 $data
     * @param string                $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::URL_PATH_EDIT

    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['quote_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item[$this::IDENTIFIRE]]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
//                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $item[$this::IDENTIFIRE]]),
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE_NEW, ['id' => $item[$this::IDENTIFIRE]]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.quote_id }"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.quote_id}" record?')
                        ]
                    ];
                    $item[$name]['reply'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_REPLY, ['id' => $item[$this::IDENTIFIRE]]),
                        'label' => __('Reply')
                    ];
                }
            }
        }
        return $dataSource;
    }
}