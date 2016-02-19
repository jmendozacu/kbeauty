<?php
/**
 * @author		Sashas
 * @category    Sashas
 * @package     Sashas_Freegift
 * @copyright   Copyright (c) 2013 Sashas IT Support Inc. (http://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)

 */

class Sashas_Freegift_Model_Resource_Rule_Apply extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('freegift/rule_apply','apply_rule_id');
    }
    
    
}