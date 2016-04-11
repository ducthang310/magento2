<?php
/**
 * Created by PhpStorm.
 * User: DUCTHANG
 * Date: 4/11/2016
 * Time: 11:28 PM
 */

namespace InterSquad\Slider\Model\ResourceModel;

/**
 * Cms page mysql resource
 */
class Slider extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Store model
     *
     * @var null|\Magento\Store\Model\Store
     */
    protected $_store = null;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;

    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->_storeManager = $storeManager;
        $this->dateTime = $dateTime;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('is_slider', 'slider_id');
    }
}
