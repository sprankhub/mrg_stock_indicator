* DOCUMENTATION

** INSTALLATION
Extract content of this archive in your Magento directory and 
activate it in the backend in the system configuration> Stock management .

** USAGE
This module is displayed on product details pages - with the help of a 'traffic light ' icon- 
the current stock of the product. The respective colour (red, yellow, 
green) of the 'traffic light' is directed by the 'Stock'  values configured in backend. 
The module supports simple and configurable products. 
The products with the stock availability 'Out of stock', is always displayed with a 
red light.

** FUNCTIONALITY
*** A: In backend - 'System -> Configuration -> Catalogue -> Stock management' - 
       the following settings are possible:
       (A1') enable 'traffic light' display.
       (A2) from which amount red is displayed.
       (A3) from which amount yellow is displayed.
       (A4) from which amount green is displayed.
*** B: End customers see below the product evaluation on the respective  
       product pages a one-color 'traffic light', which signals about the availability 
       of the product.
*** C: Support for configurable products.
       (C1) The module should also be able to present a corresponding 
       availability light for every option of the configurable product. 
       (C2) If  the stock availablility (no matter whether for simple or 
       configurable product), is set to 'Out of stock', it should be correspondingly
       displayed by the traffic light.
*** D: Helper for listen (This feature is ONLY supported for the project "jet"!!!)
There is a helper "Stock" to which one can pass a certain product model. For this special product 
Status indicator is returned. The helper can be integrated as follows:
<?
    $availability = Mage::Helper('stockindicator/stock');
    $stockState = $availability->getProductStateByQuantity($_product);
    $stockColor = $stockState['color'];
    $stockTitle = $stockState['title'];
    $stockImage = $this->getSkinUrl() . '/images/availability-' .  $stockColor . '.png';
?>
<img src="<?php echo $stockImage ?>" alt="<? echo $stockTitle; ?>" />

** TECHNICAL
In the layout file (stockindicator.xml) the 'alert.urls'' block from
<catalog_product_view> is referenced and the 'traffic light' indicator is added.
Symmetrics_StockIndicator_Block_Abstract inherits from 
Mage_Catalog_Block_Product_Abstract. Hence, it is possible, by means of 
$this-> getProduct () to access data of the product. The available  
quantity ('qty') is counterchecked with the defined quantities, to identify status 
(red, yellow, green) and to afterwards generate an HTML div block from
default values - if not explicitly overwritten by previous setters -  with 
Symmetrics_StockIndicator_Block_Abstract::_render () 
The light colour is defined with the help of the product status (red, yellow, green)
as CSS class. Children of the Symmetrics_StockIndicator_Block_Abstract 
class can overwrite class attributes, if this occurs before
_prepareLayout () of the parent class, otherwise it has no effect 
on Symmetrics_StockIndicator_Block_Abstract::getStockIndicatorAsHtml ().
As far as configurable proucts support is concerned, 
JS class is developed, which allows trafic light management in a dynamic way 
The corresponding block 
Symmetrics_StockIndicator_Block_Product_View_Type_Configurable () is registered in the 
layout file (stockindicator.xml), so that template 
stockindicator/product/view/type/configurable.phtml is only displayed for the configurable 
products. The same is also applied to class JS 
Symmetrics. Product. StockIndicatorConfig. The class has constructions which make status alterations easier. 
The PHP page deals with the preparation of a list with a number of pieces per 
Mage_Catalog_Model_Product_Type_Configurable_Attribute for every simple  
product which can be selected on the product details page. The event, 
which is triggered when the options are changed / selected by the user, 
computes a new state of the indicator.

**  PROBLEMS

Currently it is impossible to change 'red, yellow, green' threshold values per product.

* TESTCASES

** BASIC
*** A: 1. Check whether the entered values are saved in the backend. 
       2. Test switching on and off of the traffic light.
*** B: 1. Go to the frontend on a product details page, below the
          product evaluation a one-color 'traffic light' should appear. 
          To test statuses red and yellow 'earlier', set the
          values in the backend on the actual stock value of the product.
          Example: the product is given the amount of 328 items, 
          set 'red' amount to min 328 items so that this status is displayed.
*** C: 1. Repeat test case B with configurable products. For 
          this purpose create a new configurable product with more 
          than one option. Go to the frontend and observe status 
          change by option selection. Example: there are two 
          simply linked products: product A1-B1 and product-A1-B2 with 1 
          and 21 pieces in stock, where A and B are options 
          of configurable products. It is assumed, that the 
          default values of the module are entered in the system configuration. 
           
       2. (C1) Check that on the details page the yellow traffic light can be 
          seen if no option is selected. After the selection of the
          products A1-B1 the traffic light should change back from yellow to red. 
           
       3. (C2) For a particular item, with the number of pieces more than 'green' 
          (e.g., 10000), set the stock availability to 'Out of stock'. 
          Go to the details page and check whether the traffic light displayes red. 
          Repeat this procedure not only for simple products but also for configurable ones.
*** D: 1. (This feature is ONLY supported for the project "jet"!!!). Integrate the avove
mentioned code for example to catalog/product/list.phtml. The first assignment can be
integrated globally once in template, the remaining lines within the product ribbon.
2. Check if the status in the product list (or corresponding template) is shown. 		  

** CATCHABLE
*** A: 1. Backend setting is a standard functionality of Magento. 
          No sensible CATCHABLE tests are known.
*** B: 1. Carry out BASIC.B test, besides, set all the values in the 
          backend setting of the traffic light (A2-A4) to "0". The light 
          must be always green.
*** C: 1. Carry out BASIC.C test, also set all the values in the 
          backend setting of the traffic light (A2-A4) to "0". The traffic light 
          must be always green.


** STRESS
*** A: 1. Enter negative or text values in the 
          backend setting of the traffic light (A2-A4). Carry out BASIC.B 
          and BASIC.C tests.
*** B: 1. Carry out BASIC.C test, besides, the minimum / maximum number of items should be sensibly selected.
*** C: 1. Carry out BASIC.C test, besides, the minimum / maximum number of the item's options 
          should be sensibly selected.

