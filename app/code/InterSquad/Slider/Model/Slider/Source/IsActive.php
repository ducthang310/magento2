<?php
/**
 * Created by PhpStorm.
 * User: DUCTHANG
 * Date: 4/11/2016
 * Time: 10:35 PM
 */
namespace InterSquad\Slider\Model\Slider\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var \InterSquad\Slider\Model\Slider
     */
    protected $slider;

    /**
     * Constructor
     *
     * @param \Magento\Cms\Model\Page $cmsPage
     */
    public function __construct(\InterSquad\Slider\Model\Slider $slider)
    {
        $this->slider = $slider;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->slider->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}

