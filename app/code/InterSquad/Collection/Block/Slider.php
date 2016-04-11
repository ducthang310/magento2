<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace InterSquad\Collection\Block;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;

/**
 * Collection block
 */
class Collection extends Template
{
    protected $_baseData = null;
    protected $_imagePath = null;

    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
        $this->getBaseData($data['collection_code']);
    }

    /**
     * @return DataObject
     */
    public function getBaseData()
    {
        if (!$this->_baseData) {
            // Call model to get data by collection_code
            $data = new DataObject();
            $data->_data = array(
                'collection_id' => 1,
                'code' => 'sl_homepage_top',
                'status' => 1,
                'rules' => array(),
                'addition' => '',
//                'custom_css' => '.collection_home_top {width: 100%; background-color: #444333;}',
//                'custom_js' => 'alert("Your custom js has been added successfully.")'
            );

            $data->setImages($this->_prepareCollectionData($data->getRules()));
                
            $this->_baseData = $data;
        }

        return $this->_baseData;
    }

    public function getCollectionPath()
    {
        if (!$this->_imagePath) {
            $this->_imagePath = $this->getUrl('pub/media/inter_squad/collections/' . $this->getCollectionCode(), ['_secure' => $this->getRequest()->isSecure()]);
        }
        return $this->_imagePath;
    }
    
    protected function _prepareCollectionData($rules)
    {
        $col = null;
        
        return $col;
    }
}
