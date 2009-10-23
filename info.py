# encoding: utf-8


# =============================================================================
# package info
# =============================================================================
NAME = 'symmetrics_module_stock_indicator'

TAGS = ('magento', 'symmetrics', 'module', 'stock', 'indicator', 'germanconfig', 'locpack')

LICENSE = 'AFL 3.0'

HOMEPAGE = 'http://www.symmetrics.de'

INSTALL_PATH = ''


# =============================================================================
# responsibilities
# =============================================================================
TEAM_LEADER = {
    'Sergej Braznikov': 'sb@symmetrics.de'
}

MAINTAINER = {
    'Andreas Timm': 'at@symmetrics.de'
}

AUTHORS = {
    'Andreas Timm': 'at@symmetrics.de'
}

# =============================================================================
# additional infos
# =============================================================================
INFO = 'Ampel für Lagerbestand'

SUMMARY = '''
    Zeigt 3-farbiger Ampel. Die Einstellungen dafür findet man unter
    Admin Panel/System/Configuration/Inventory/Stock Indicator.
'''

NOTES = '''
'''

# =============================================================================
# relations
# =============================================================================
REQUIRES = {
}

EXCLUDES = {
}

DEPENDS_ON_FILES = (
    'app/code/core/Mage/Catalog/Block/Product/View.php'
    'app/code/core/Mage/Catalog/Block/Product/List.php'
)

PEAR_KEY = ''

COMPATIBLE_WITH = {
    'magento': ['1.3.2.1', '1.3.2.3', '1.3.2.4'],
}
