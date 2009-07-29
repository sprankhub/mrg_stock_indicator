<?php
/**
 * @category Symmetrics
 * @package Symmetrics_StockIndicator
 * @author symmetrics gmbh <info@symmetrics.de>, Andreas Timm <at@symmetrics.de>
 * @copyright symmetrics gmbh
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software 
 */
class Symmetrics_StockIndicator_Block_Indicator extends Mage_Catalog_Block_Product_View
{
	
	protected $productId;
	
    public function getAvailabilityClass()
    {
        if (Mage::getStoreConfig('cataloginventory/stock_indicator/indicator_show') == 1) {
            if(!isset($this->productId)) {
            	$product = $this->getProduct();
            }
            else {
            	$product = Mage::getModel('catalog/product')->load($this->productId);
            }
            $qty = $product->getData('stock_item')->getData('qty');
            $config = Mage::getStoreConfig('cataloginventory/stock_indicator');
            $aviability_class = 'red';
            $keys = array('red', 'yellow', 'green');
            foreach ($keys as $key) {
                if ($qty >= $config[$key]) {
                    $aviability_class = $key;
                }
            }
        }
        else {
            $aviability_class = false;
        }
        return $aviability_class;
    }
    
    function setProductIdAvail($productId)
    {
    	$this->productId = $productId;
    }
}