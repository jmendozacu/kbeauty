<?php
class Aitoc_Aitreports_Helper_Processor extends Mage_Core_Helper_Abstract
{
    protected $_types = array(
        'export' => 'Export',
    );
    
    protected $_methods = array(
        'export' => array(
            'initExport'        => 'Initialization',
            'makeExport'        => 'Processing Data',
            'finalizeXmlExport' => 'Processing Data',
            'finishExport'      => 'Finalizing',   
        ),
    );
    
    /**
     * Get friendly process name
     * 
     * @param string $process
     * @return string
     */
    public function getProcessName($process)
    {
        list($processType, $processMethod) = explode('::', $process);
        
        return $this->__($this->_types[$processType]).' - '.$this->__($this->_methods[$processType][$processMethod]);
    }
    
    /**
     * Get process completeness percent
     *
     * @param array $options
     * @return integer
     */
    public function calculatePercent($options)
    {
        if(isset($options['limit']))
        {
            if($options['from'] > 0)
            {
                return round($options['from'] / $options['entities'] * 100);
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 100;
        }
    }
}
