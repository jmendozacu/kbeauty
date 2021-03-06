<?php
/**
 * Kodematix
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@Kodematix.com so we can send you a copy immediately.
 * 
 * @category    Kodematix
 * @package     Kodematix_ShippingTablerate
 * @copyright   Copyright (c) 2011 Kodematix (http://www.Kodematix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Table rate resource model
 *
 * @category   Kodematix
 * @package    Kodematix_ShippingTablerate
 * @author     Kodematix Team <sales@kodematix.com>
 */
class Kodematix_ShippingTablerate_Model_Mysql4_Tablerate extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Constructor
     */
    protected function _construct() {
        $this->_init('shippingtablerate/tablerate', 'pk');
    }
    /**
     * Perform actions before object save
     *
     * @param Mage_Core_Model_Abstract $object
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object) {
        parent::_beforeSave($object);
        return $this;
    }
    /**
     * Load table rate by request
     * 
     * @param Kodematix_ShippingTablerate_Model_Tablerate $tablerate
     * @param Varien_Object $request
     * @return Kodematix_ShippingTablerate_Model_Mysql4_Tablerate
     */
    public function loadByRequest(Kodematix_ShippingTablerate_Model_Tablerate $tablerate, Varien_Object $request)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()->from($this->getMainTable());
        $conditions = array();
        if ($request->getId()) array_push($conditions, '(pk != '.$adapter->quote($request->getId()).')');
        $websiteId = ($request->getWebsiteId()) ? $request->getWebsiteId() : '0';
        $destCountryId = ($request->getDestCountryId()) ? $request->getDestCountryId() : '0';
        $destRegionId = ($request->getDestRegionId()) ? $request->getDestRegionId() : '0';
        $destZip = ($request->getDestZip()) ? $request->getDestZip() : '';
        $conditionName = ($request->getConditionName()) ? $request->getConditionName() : '';
        $conditionValue = ($request->getConditionValue()) ? $request->getConditionValue() : '';
        array_push($conditions, '(website_id = '.$adapter->quote($websiteId).')');
        array_push($conditions, '(dest_country_id = '.$adapter->quote($destCountryId).')');
        array_push($conditions, '(dest_region_id = '.$adapter->quote($destRegionId).')');
        array_push($conditions, '(dest_zip = '.$adapter->quote($destZip).')');
        array_push($conditions, '(condition_name = '.$adapter->quote($conditionName).')');
        array_push($conditions, '(condition_value = '.$adapter->quote($conditionValue).')');
        $select->where(implode(' AND ', $conditions));
        $select->limit(1);
        $row = $adapter->fetchRow($select);
        if ($row && !empty($row)) $tablerate->setData($row);
        $this->_afterLoad($tablerate);
        return $this;
    }
}