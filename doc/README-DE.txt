* DOCUMENTATION

** INSTALLATION
Extrahieren Sie den Inhalt dieses Archivs in Ihr Magento Verzeichnis und aktivieren
es im Backend in der Systemkonfiguration > Lagerwaltung.

** USAGE
Dieses Modul zeigt auf Produktdetail-Seiten - anhand eines 'Ampel'-Symbols - den
aktuellen Warenbestand des Produkts an.
Die jeweilige Farbe (rot, gelb, grün) der 'Ampel' richtet sich nach den im Backend
konfigurierten 'Stock'-Werten.

** FUNCTIONALITY
*** A: Im Backend - 'System > Konfiguration - Katalog > Lager' - liegen nun folgende
Einstellmöglichkeiten vor:
**** A.1: 'Ampel'-Anzeige aktivieren
**** A.2: ab welcher Menge rot angezeigt wird
**** A.3: ab welcher Menge gelb angezeigt wird
**** A.4: ab welcher Menge grün angezeigt wird
*** B: Endkunden sehen unterhalb der Produktbewertung auf der jeweiligen Produktseite
eine einfarbige 'Ampel', die die Verfügbarkeit des Produkts signalisiert.
*** C: Unterstützung für Configurable Products 

** TECHNINCAL
*** In der Layout Datei (stockindicator.xml) wird der 'alert.urls' Block von
<catalog_product_view> referenziert und der 'Ampel'-Indikator eingefügt.
Symmetrics_StockIndicator_Block_Abstract erbt von Mage_Catalog_Block_Product_Abstract.
Daher ist es möglich, mittels $this->getProduct() auf die Daten des Produkts zu
zugreifen. Die vorhandene Menge ('qty') wird mit den definierten Mengen gegengeprüft
um den Status (rot,gelb,grün) zu ermitteln und anschließend mit
Symmetrics_StockIndicator_Block_Abstract::_render() einen HTML div-Block aus Default
Werten - wenn nicht explizit vorher mit den Settern überschrieben - zu generieren.
Die Ampel Farbe wird anhand des Produkt-Status (rot,gelb,grün) als CSS-Klasse
definiert.
Kinder der Symmetrics_StockIndicator_Block_Abstract Klasse können die Klassen-
Attribute überschreiben, wenn diese vor dem _prepareLayout() der Elternklasse
erfolgt, sonst hat es keine Auswirkung auf
Symmetrics_StockIndicator_Block_Abstract::getStockIndicatorAsHtml().
*** Was die Unterstützung für Configurable Products betrifft, wurde es eine 
JS Klasse entwickelt, die die Verwaltung der Ampel auf dynamischen Wege ermöglicht. 
Der entsprechende Block Symmetrics_StockIndicator_Block_Product_View_Type_Configurable() 
ist in der Layout Datei (stockindicator.xml) registriert, so dass das Template
stockindicator/product/view/type/configurable.phtml nur für die Configurable 
Products angezeigt wird. Das Gleiche gilt auch für die JS Klasse 
Symmetrics.Product.StockIndicatorConfig. Die Klasse verfügt über Konstruktionen
die die Änderung des Status erleichtern.
Die PHP-Seite beschäftigt sich mit der Vorbereitung einer Liste mit Stückzahl pro 
Mage_Catalog_Model_Product_Type_Configurable_Attribute für jedes einfache Produkt, 
das man auf die Produktdetail-Seite auswählen kann. Das Ereignis, das ausgelöst wird,
wenn die Optionen vom Benutzer geändert/ausgewählt werden, berechnet den neuen 
Status des Indikators.

** PROBLEMS
*** Derzeit ist es nicht möglich die 'rot,gelb,grün'-Schwellenwerte pro Produkt zu
    ändern.

* TESTCASES
** BASIC
*** A: Prüfen Sie, ob die eingebenen Werte im Backend gespeichert werden.

*** B: Gehen Sie im Frontend auf eine Produktdetails Seite, unterhalb der Produkt-
bewertung sollte jetzt eine einfarbige 'Ampel' erscheinen. Um die Status 'rot' und
'gelb' 'frühzeitiger' zu testen, sind die Werte im Backend auf den tatsächlichen
Stock Wert des Produkts zu setzen.
Bsp: Vom Produkt ist die Menge von 328 Stck. gegeben, die 'red'-Menge min. auf
328 setzen damit dieser Status angezeigt wird.

*** С: Wiederholen Sie Testcase B mit konfigurierbaren Produkten.
Für diesen Zweck legen Sie ein neues konfigurierbares Produkt mit mehr als einer
Option an. Gehen Sie ins Front-End und beobachten sie die Änderung des Status bei der
Options-Auswahl.
Bsp.: Es gibt zwei einfache verknüpfte Artikel: Artikel-A1-B1 und Artikel-A1-B2 mit
1 und 21 Stück auf dem Lager, wobei A und B Optionen des konfigurierbaren Artikels sind.
Es wird davon ausgegangen, dass die Standardwerte des Moduls in der Systemkonfiguration
eingetragen sind.
Überprüfen Sie, dass auf der Detail-Seite die gelbe Ampel zu sehen ist, wenn keine 
Option ausgewählt ist. Nach der Auswahl von Artikel-A1-B1 sollte die Ampel von gelb 
auf rot wechseln.

** CATCHABLE

** STRESS
