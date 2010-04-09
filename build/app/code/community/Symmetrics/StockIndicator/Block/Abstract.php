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
 * @author    Symmetrics GmbH <info@symmetrics.de>
 * @author    Andreas Timm <at@symmetrics.de>
 * @author    Ngoc Anh Doan <nd@symmetrics.de>
 * @copyright 2010 Symmetrics GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */

/**
 * Abstract StockIndicator block class
 *
 * @category  Symmetrics
 * @package   Symmetrics_StockIndicator
 * @author    Symmetrics GmbH <info@symmetrics.de>
 * @author    Andreas Timm <at@symmetrics.de>
 * @author    Ngoc Anh Doan <nd@symmetrics.de>
 * @copyright 2010 Symmetrics GmbH
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
abstract class Symmetrics_StockIndicator_Block_Abstract extends Mage_Catalog_Block_Product_Abstract
{
    /**
     * This configuration path has currently 3 key => value pairs and presents the state
     * of a product:
     *
     * - red
     * - yellow
     * - green
     *
     * Values (stock/quantity) defines when which state gets assign to a product
     *
     * @see Symmetrics_StockIndicator_Block_Abstract::setProductState()
     */
    protected $_stockIndicatorConfigPath = 'cataloginventory/stock_indicator';
    
    /**
     * Default alignment of the 'Ampel' indicator. Used as css class to get it
     * horizontal of vertical
     *
     * @var string  horizontal | vertical
     */
    protected $_alignment = 'horizontal';

    /**
     * The configuration path, to check whether the
     *
     * @var string
     */
    protected $_viewEnabledConfigPath = 'cataloginventory/stock_indicator/product_view_enabled';

    /**
     * The stock indicator is enabled for defined view.
     * This is setted in the backend.
     *
     * @see $_viewEnabledConfigPath
     *
     * @var 0|1
     */
    protected $_isEnabled = null;

    /**
     * Options and data for the indicator:
     *
     * - Css classes
     * - Indicator product state (red | yellow | green)
     * - HTML tag, default is div (<div></div>)
     * - HTML attribute 'title'
     * - Stock indicator as HTML block
     *
     * Array keys:
     *
     * - html_tag
     * - css_class
     * - product_state
     * - state_title
     * - stockindicator_as_html
     *
     * @var array
     */
    protected $_options = array();

    /**
     * Inherited classes can overwrite class::$attributes within this method
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        $this->init();
    }

    /**
     * Initialize:
     *
     * Sets some default options and checks if this module ist enabled
     *
     * @return void
     */
    public function init()
    {
        if (!$this->isEnabled()) {
            return;
        }

        /**
         * @see Symmetrics_StockIndicator_Block_Abstract::->_stockIndicatorConfigPath
         */
        $stockIndicatorConfig = Mage::getStoreConfig($this->_stockIndicatorConfigPath);
        $stock = $this->getProductStock();
        // Array for the following foreach statement
        $states = array('red', 'yellow', 'green');

        // Sets state and HTML title attribute of product
        foreach ($states as $state) {
            if ($stock >= $stockIndicatorConfig[$state]) {
                $this->setProductState($state);

                switch ($state) {
                    case 'red':
                        $this->setStateTitle($this->__('Currently out of stock!'));
                        break;
                    case 'yellow':
                        $this->setStateTitle($this->__('Moderate stock!'));
                        break;
                    case 'green':
                        $this->setStateTitle($this->__('In stock'));
                        break;
                    default:
                        break;
                }
            }
        }

        // Default css classes
        $this->addCssClass('stock-indicator ' . $this->getAlignment() . ' ' . $this->getProductState());
    }

    /**
     * Indicator is enabled or not
     *
     * @see $_isEnabled
     * @return bool 1|0
     */
    public function isEnabled()
    {
        if ($this->_isEnabled === null) {
            $this->_isEnabled = Mage::getStoreConfig($this->_viewEnabledConfigPath);
        }

        return $this->_isEnabled;
    }

    /**
     * Additional css class for the StockIndicator
     *
     * @param string $class string of css classes
     *
     * @return Symmetrics_StockIndicator_Block_Abstract
     */
    public function addCssClass($class)
    {
        $class = trim($class);
        ($this->getCssClass()) ? $this->setCssClass($this->getCssClass() . " $class") : $this->setCssClass($class);

        return $this;
    }

    /**
     * If no tag is set, div gets set as default HTML tag
     *
     * @return string  HTML tag
     */
    public function getHtmlTag()
    {
        if (!$this->getOption('html_tag')) {
            $this->setHtmlTag('div');
        }

        return $this->getOption('html_tag');
    }

    /**
     * Css classes for HTML
     *
     * @return string  css classes
     */
    public function getCssClass()
    {
        return $this->getOption('css_class');
    }

    /**
     * Current stock state of product which is defined in the backend and depends
     * on the stock|quantity
     *
     * @return string  red | yellow | green
     */
    public function getProductState()
    {
        return $this->getOption('product_state');
    }

    /**
     * HTML attribute - title - which will shown on hover indicator
     *
     * @return string  HTML title
     */
    public function getStateTitle()
    {
        return $this->getOption('state_title');
    }

    /**
     * Getter method for the options array
     *
     * @param string $key array index
     *
     * @return string|bool
     * @see Symmetrics_StockIndicator_Block_Abstract::_options
     */
    public function getOption($key)
    {
        $key = trim($key);
        return isset($this->_options[$key]) ? $this->_options[$key] : false;
    }

    /**
     * Alignment of indicator, default is 'horizontal'
     *
     * @see Symmetrics_StockIndicator_Block_Abstract::_alignment
     * @see Symmetrics_StockIndicator_Block_Abstract::setAlignment()
     * @return string  alignment
     */
    public function getAlignment()
    {
        return $this->_alignment;
    }

    /**
     * Gets product ID
     *
     * @return int  product ID
     */
    public function getProductId()
    {
        return $this->getProduct()->getId();
    }

    /**
     * Gets current stock of product
     *
     * @param Mage_Catalog_Model_Product $product specific product
     *
     * @return int  stock/quantity
     */
    public function getProductStock($product = null)
    {
        if (null !== $product) {
            $stockItem = $product->getStockItem();
        } else {
            $stockItem =  $this->getProduct()->getStockItem();
        }
        
        return (int) $stockItem->getQty() - $stockItem->getMinQty();
    }

    /**
     * Css class(es) used for the HTML code
     *
     * @param string $tag css class(es)
     *
     * @return Symmetrics_StockIndicator_Block_Abstract
     * @see Symmetrics_StockIndicator_Block_Abstract::_render()
     */
    public function setHtmlTag($tag)
    {
        return $this->setOption('html_tag', strtolower($tag));
    }

    /**
     * Css class(es) used for the HTML code
     *
     * @param string $class css class(es)
     *
     * @return Symmetrics_StockIndicator_Block_Abstract
     * @see Symmetrics_StockIndicator_Block_Abstract::_render()
     */
    public function setCssClass($class)
    {
        return $this->setOption('css_class', $class);
    }

    /**
     * Product's indicator state which gets added as css class
     *
     * @param string $state red|yellow|green
     *
     * @return Symmetrics_StockIndicator_Block_Abstract
     * @see Symmetrics_StockIndicator_Block_Abstract::_render()
     */
    public function setProductState($state)
    {
        return $this->setOption('product_state', $state);
    }

    /**
     * HTML attribute: title - part of the HTML code
     *
     * @param string $title HTML title
     *
     * @return Symmetrics_StockIndicator_Block_Abstract
     * @see Symmetrics_StockIndicator_Block_Abstract::_render()
     */
    public function setStateTitle($title)
    {
        return $this->setOption('state_title', $title);
    }

    /**
     * Setter for the options array
     *
     * @param string $index key index
     * @param string $value array value
     *
     * @return Symmetrics_StockIndicator_Block_Abstract
     * @see Symmetrics_StockIndicator_Block_Abstract::_options
     */
    public function setOption($index, $value)
    {
        $this->_options[trim($index)] = trim($value);
        return $this;
    }

    /**
     * Inherited class have to define this config path
     *
     * @param string $pathString config path
     *
     * @return Symmetrics_StockIndicator_Block_Abstract
     * @see Symmetrics_StockIndicator_Block_Abstract::_viewEnabledConfigPath
     */
    public function setViewEnabledConfigPath($pathString)
    {
        $this->_viewEnabledConfigPath = (string) trim($pathString);
        return $this;
    }

    /**
     * This attribute defines as css class whether the indicator is displayed
     * horizontal or vertical
     *
     * @param string $alignment css class: horizontal|vertical
     *
     * @return Symmetrics_StockIndicator_Block_Abstract
     * @see Symmetrics_StockIndicator_Block_Abstract::_render()
     */
    public function setAlignment($alignment)
    {
        $this->_alignment = strtolower(trim($alignment));
        return $this;
    }
}