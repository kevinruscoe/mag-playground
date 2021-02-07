<?php

namespace KevinRuscoe\Playground\Block\Cart\Item\Renderer;

use Magento\Framework\App\ObjectManager;

class Sample extends \Magento\Checkout\Block\Cart\Item\Renderer
{
    private $baseProduct;

    public function getBaseProduct()
    {
        if (is_null($this->baseProduct)) {

            $baseProductId = null;

            foreach ($this->getOptionList() as $_option) {
                if ($_option['label'] === 'Base Product ID') {
                    $baseProductId = $_option['value'];
                    break;
                }
            }
    
            $this->baseProduct = ObjectManager::getInstance()
                ->get(\Magento\Catalog\Model\ProductFactory::class)
                ->create()
                ->load($baseProductId);

            if (! $this->baseProduct->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->baseProduct;
    }
}