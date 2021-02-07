<?php

namespace KevinRuscoe\Playground\Model\Product\Type;

class SampleProduct extends \Magento\Catalog\Model\Product\Type\AbstractType 
{
    const TYPE_CODE = 'sample';

    public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product)
    {
        
    }
}