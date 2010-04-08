* DOCUMENTATION

** INSTALLATION
Extrahieren Sie den Inhalt dieses Archivs in Ihr Magento Verzeichnis und aktivieren
es im Backend in der Systemkonfiguration > Lagerwaltung.

** USAGE
Dieses Modul zeigt auf Produktdetail-Seiten, anhand eines 'Ampel'-Symbols den
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

** TECHNINCAL
*** In der Layout Datei (stockindicator.xml) wird auf 'alert.urls' Block von
<catalog_product_view> referenziert und der 'Ampel'-Indikator eingefügt.
Symmetrics_StockIndicator_Block_Abstract erbt von Mage_Catalog_Block_Product_Abstract.
Daher ist es möglich, mittels $this->getProduct() auf die Daten des Produkts zu
zugreifen. Die vorhandene Menge ('qty') wird mit den definierten Mengen gegengeprüft
um den Status (rot,gelb,grün) zu ermitteln und anschließend mit
Symmetrics_StockIndicator_Block_Abstract::_render() ein HTML div-Block aus Default
Werten - wenn nicht explizit vorher mit den Settern überschrieben - zu generieren.
Die Ampel Farbe wird anhand des Produkt-Status (rot,gelb,grün) als CSS-Klasse
definiert.
Kinder der Symmetrics_StockIndicator_Block_Abstract Klasse, können die Klassen-
Attribute überschreiben, wenn diese vor dem _prepareLayout() der Elternklasse
erfolgt, sonst hat es keine Auswirkung auf
Symmetrics_StockIndicator_Block_Abstract::getStockIndicatorAsHtml().

** PROBLEMS
*** Derzeit ist es nicht möglich 'rot,gelb,grün'-Mengen für Produkt-Gruppen oder
einzelne Produkte zu definieren.

* TESTCASES
** BASIC
*** A: Nach abspeichern der Mengenwerte, sollten die Werte gesetzt sein und nicht
die ursprünglichen Werte haben.
Ggf. kann mit einer SQL-Abfrage gegengeprüft werden:
----
SELECT *
FROM `core_config_data`
WHERE (`path` LIKE 'cataloginventory/stock_indicator%')
----
Das Ergebnis enthält die im Backeng gesetzten Werte.
*** B: Gehen Sie im Frontend auf eine Produktdetail Seite, unterhalb der Produkt-
bewertung sollte jetzt eine einfarbige 'Ampel' erscheinen. Um die Status 'rot' und
'gelb' 'frühzeitiger' zu testen, sind die Werte im Backend auf den tatsächlichen
Stock Wert des Produkts zu setzen.
Bsp: Vom Produkt ist die Menge von 328 Stck. gegeben, die 'red'-Menge min. auf
328 setzen damit dieser Status angezeigt wird.

** CATCHABLE

** STRESS
