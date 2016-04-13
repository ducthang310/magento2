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
    public function __construct(
        Template\Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
        $this->loadData($data['slider_code']);
    }

    /**
     * @return DataObject
     */
    public function loadData($identifier)
    {
        if (!$this->_baseData) {
            // Call model to get data by slider_code
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $model = $objectManager->create('InterSquad\Slider\Model\Slider');
            $model->load($identifier, 'identifier');
            if ($model) {
                $images = $this->_prepareImageData(unserialize($model->getImages()));
                $model->setImages($images);

// a:2:{s:7:"image_1";a:1:{s:4:"path";s:31:"/c/a/casey-shirt-silk-front.jpg";}s:7:"image_2";a:1:{s:4:"path";s:25:"/m/o/moto-homepage.fw.png";}}
            }
                
            $this->_baseData = $model;
        }

        return $this->_baseData;
    }

    public function getBaseData() {
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
