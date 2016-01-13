<?php

class Aitoc_Aitreports_Model_Export_Type_Aitcheckoutfields implements Aitoc_Aitreports_Model_Export_Type_Interface
{
    /**
     * 
     * @param SimpleXMLElement $invoiceXml
     * @param Mage_Sales_Model_Order_Invoice $invoice
     * @param Varien_Object $exportConfig
     */
    
    private function _getOrderCustomData($order)
    {
        $iStoreId = $order->getStoreId();
        $iOrderId = $order->getId();

        $oAitcheckoutfields  = Mage::getModel('aitcheckoutfields/aitcheckoutfields');

        $aCustomAtrrList = $oAitcheckoutfields->getOrderCustomData($iOrderId, $iStoreId, true, true);    
        
        return $aCustomAtrrList;
    }
    
    public function prepareXml(SimpleXMLElement $orderXml, Mage_Core_Model_Abstract $order, Varien_Object $exportConfig)
    {
        if(!Mage::helper('aitreports/aitcheckoutfields')->isEnabled())
        {
            return false;
        }

        if (empty($exportConfig['entity_type']['aitcheckoutfields']))
        {
            return false;
        }

        $cfmFieldsXml = $orderXml->addChild('aitcheckoutfields');
        if($allCFMFields = $this->_getOrderCustomData($order))
        {
            $filteredCFMFieldNames = array_keys($exportConfig['entity_type']['aitcheckoutfields']);

            foreach ($allCFMFields as $cfmField)
            {
                if(in_array($cfmField['code'], $filteredCFMFieldNames))
                {
                    $cfmFieldCodeXml = $cfmFieldsXml->addChild('aitbl_'.$cfmField['code']);
                    if ($cfmField['type'] == 'boolean')
                    {
                        $cfmField['value'] = $cfmField['rawval'];
                    }
                    $values = explode(',', $cfmField['value']);
                    $iterator = 0;
                    foreach($values as $value)
                    {
                        $cfmFieldCodeXml->addChild('value'.(++$iterator), trim($value));
                    }
                }
            }
        }
    }
    
    public function getCFMFields()
    {
        if(!Mage::helper('aitreports/aitcheckoutfields')->isEnabled())
            return null;
        
        $entityType = Mage::getModel('eav/config')->getEntityType('aitoc_checkout');
        $entityTypeId = $entityType->getEntityTypeId();
 
        $collection = Mage::getResourceModel('eav/entity_attribute_collection')
                ->setEntityTypeFilter($entityTypeId);
                
        return $collection;
    }
}
