<?php

namespace KevinRuscoe\Playground\Controller\Cart;

use Magento\Framework\App\Action\Context;
use Magento\Checkout\Model\Cart;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Controller\ResultFactory; 
use Magento\Catalog\Model\ProductFactory;

class Add extends \Magento\Framework\App\Action\Action
{
	protected $cart;

	protected $formKeyValidator;

	protected $resultFactory;

	protected $productFactory;

	public function __construct(
		Context $context,
		Cart $cart,
		Validator $formKeyValidator,
		ResultFactory $resultFactory,
		ProductFactory $productFactory
    )
	{		
		$this->cart = $cart;
		$this->formKeyValidator = $formKeyValidator;
		$this->resultFactory = $resultFactory;
		$this->productFactory = $productFactory;

		return parent::__construct($context);
	}

	public function execute()
	{
		// Prep redirect
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

		$resultRedirect->setUrl($this->_redirect->getRefererUrl());

		// Validate key
		if (! $this->formKeyValidator->validate($this->getRequest())) {
			return $resultRedirect;
        }

		// Get product, and the base sample product
		$baseSampleProduct = $this->getBaseSampleProduct();
		$product = $this->getProduct();

		// add to cart
        $this->cart->addProduct($baseSampleProduct, [
			'qty' => 1,
			'product' => $baseSampleProduct->getId(),
			'options' => [
				5 => $product->getId()
			]
		])->save();
		
		// update message
		$this->messageManager->addSuccessMessage(
			__(
				'You added a sample of %1 to your shopping cart.',
				$product->getName()
			)
		);

		// redirect
		return $resultRedirect;
	}

    private function getBaseSampleProduct()
    {
		$baseSampleProduct = $this->productFactory->create()->load(2052);

		if (! $baseSampleProduct->getId()) {
			throw new LocalizedException(__('Failed to initialize product'));
		}

        return $baseSampleProduct;
    }

	private function getProduct()
    {
		$product = $this->productFactory->create()->load($this->_request->getParam('product_id'));

		if (! $product->getId()) {
			throw new LocalizedException(__('Failed to initialize product'));
		}

        return $product;
    }
}
