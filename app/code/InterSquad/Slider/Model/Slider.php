<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace InterSquad\Slider\Model;

use InterSquad\Slider\Api\Data\PageInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Cms Page Model
 *
 * @method \InterSquad\Slider\Model\ResourceModel\Page _getResource()
 * @method \InterSquad\Slider\Model\ResourceModel\Page getResource()
 */
class Slider extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{
    const SLIDER_ID                = 'slider_id';
    const IDENTIFIER               = 'identifier';
    const TITLE                    = 'title';
    const IMAGES                   = 'images';
    const CREATION_TIME            = 'creation_time';
    const UPDATE_TIME              = 'update_time';
    const IS_ACTIVE                = 'is_active';
    
    /**
     * No route page id
     */
    const NOROUTE_SLIDER_ID = 'no-route';

    /**#@+
     * Page's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'is_slider';

    /**
     * @var string
     */
    protected $_cacheTag = 'is_slider';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'is_slider';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('InterSquad\Slider\Model\ResourceModel\Slider');
    }

    /**
     * Load object data
     *
     * @param int|null $id
     * @param string $field
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRoutePage();
        }
        return parent::load($id, $field);
    }

    /**
     * Load No-Route Page
     *
     * @return \InterSquad\Slider\Model\Slider
     */
    public function noRoutePage()
    {
        return $this->load(self::NOROUTE_SLIDER_ID, $this->getIdFieldName());
    }

    /**
     * Prepare page's statuses.
     * Available event is_slider_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::SLIDER_ID);
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get page layout
     *
     * @return string
     */
    public function getImages()
    {
        return $this->getData(self::IMAGES);
    }

    /**
     * Get creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Get update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     */
    public function setId($id)
    {
        return $this->setData(self::SLIDER_ID, $id);
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return \InterSquad\Slider\Api\Data\PageInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \InterSquad\Slider\Api\Data\PageInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \InterSquad\Slider\Api\Data\PageInterface
     */
    public function setImages($images)
    {
        return $this->setData(self::IMAGES, $images);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return \InterSquad\Slider\Api\Data\PageInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return \InterSquad\Slider\Api\Data\PageInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return \InterSquad\Slider\Api\Data\PageInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
}
