<?php

namespace KevinRuscoe\Playground\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Catalog\Model\ProductFactory;

class AddSampleForm extends Template 
{
    protected $registry;

    private $productFactory;

    private $currentProduct;

    private $formKey;

    public function __construct(
        Context $context, 
        Registry $registry, 
        ProductFactory $productFactory,
        array $data = array()
    ) 
    {
        $this->registry = $registry;

        $this->productFactory = $productFactory;

        parent::__construct($context, $data);
    }

    private function getCurrentProduct()
    {
        if (is_null($this->currentProduct)) {
            $this->currentProduct = $this->registry->registry('product');

            if (! $this->currentProduct->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->currentProduct;
    }

    public function getCurrentProductId()
    {
        return $this->getCurrentProduct()->getId();
    }

    public function getFormUrl()
    {
        return "/sample/cart/add";
    }
}