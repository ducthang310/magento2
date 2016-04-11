<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace InterSquad\Slider\Block;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;

/**
 * Main contact form block
 */
class Slider extends Template
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
        $this->getBaseData($data['slider_code']);
    }

    /**
     * @return DataObject
     */
    public function getBaseData()
    {
        if (!$this->_baseData) {
            // Call model to get data by slider_code
            $data = new DataObject();
            $data->_data = array(
                'slider_id' => 1,
                'code' => 'sl_homepage_top',
                'status' => 1,
                'images' => array(
                    array(
                        'url' => 'images/fap1.jpg',
                        'title' => 'Image 1',
                        'alt' => 'Image 1',
                        'position' => 2
                    ),
                    array(
                        'url' => 'images/fap2.jpg',
                        'title' => 'Image 2',
                        'alt' => 'Image 2',
                        'position' => 1
                    ),
                    array(
                        'url' => 'images/fap3.jpg',
                        'title' => 'Image 3',
                        'alt' => 'Image 3',
                        'position' => 0
                    )
                ),
                'addition' => '',
                'custom_css' => '.slider_home_top {width: 100%; background-color: #444333;}',
                'custom_js' => 'alert("Your custom js has been added successfully.")'
            );

            $data->setImages($this->_prepareImageData($data->getImages()));
                
            $this->_baseData = $data;
        }

        return $this->_baseData;
    }

    public function getSliderPath()
    {
        if (!$this->_imagePath) {
            $this->_imagePath = $this->getUrl('pub/media/inter_squad/sliders/' . $this->getSliderCode(), ['_secure' => $this->getRequest()->isSecure()]);
        }
        return $this->_imagePath;
    }
    
    protected function _prepareImageData($images)
    {
        $count = count($images);
        if (0 < $count) {
            for ($i = 0; $i < $count; $i++) {
                $images[$i]['url'] = $this->getSliderPath() . $images[$i]['url'];
            }

            // Sort by priority
            usort($images, function ($image1, $image2) {
                if ($image1['position'] == $image2['position']) {
                    return 0;
                }
                return ($image1['position'] < $image2['position']) ? -1 : 1;
            });
        }
        
        return $images;
    }
}
