<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  Symmetrics
 * @package   Symmetrics_StockIndicator
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Andreas Timm <at@symmetrics.de>
 * @author    Ngoc Anh Doan <nd@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */

/**
 * StockIndicator helper class for getting the stock indicator for a given product
 *
 * @category  Symmetrics
 * @package   Symmetrics_StockIndicator
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Eric Reiche <er@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
class Symmetrics_StockIndicator_Helper_Stock extends Mage_Core_Helper_Abstract
{
    /**
     * Get product state
     * 
     * @param Mage_Catalog_Model_Product $product Product model
     *
     * @return array (color, title)
     */
    public function getProductStateByQuantity($product)
    {
        $state = array();
        /* @var Symmetrics_StockIndicator_Model_Config $configModel */
        $configModel = Mage::getSingleton('stockindicator/config');

        // Array for the following foreach statement
        $states = array(
            Symmetrics_StockIndicator_Block_Abstract::RED_STATE,
            Symmetrics_StockIndicator_Block_Abstract::YELLOW_STATE,
            Symmetrics_StockIndicator_Block_Abstract::GREEN_STATE
        );

        $configQuantities = $configModel->getConfig();
        $productQuantity = $this->getProductStockQuantity($product);

        // Sets state and HTML title attribute of product
        // based on quantity matching against configuration values
        if (!$this->isProductInStock($product)) {
            $state['color'] = $state;
            $state['title'] = $this->__('Currently out of stock!');
            
            return $state;
        }
        foreach ($states as $state) {
            if ($productQuantity >= $configQuantities[$state]) {
                $returnState['color'] = $state;
                
                switch ($state) {
                    case $states[0]:
                        $returnState['title'] = $this->__('Currently out of stock!');
                        break;
                    case $states[1]:
                        $returnState['title'] = $this->__('Only a few available!');
                        break;
                    case $states[2]:
                        $returnState['title'] = $this->__('In stock');
                        break;
                    default:
                        throw new Exception('Invalid stock state');
                }
            }
        }
        
        return $returnState;
    }
    
    /**
     * Gets current stock of the product
     *
     * @param Mage_Catalog_Model_Product $product Product model
     *
     * @return int stock/quantity
     */
    public function getProductStockQuantity($product)
    {
        $stockItem = $product->getStockItem();
        
        return (int) $stockItem->getQty() - $stockItem->getMinQty();
    }

    /**
     * Test stock availability
     *
     * @param Mage_Catalog_Model_Product $product Product model
     *
     * @return boolean true if product is in stock
     */
    public function isProductInStock($product)
    {
        $isInStock = $product->getStockItem()->getIsInStock();

        return (boolean) $isInStock;
    }
}