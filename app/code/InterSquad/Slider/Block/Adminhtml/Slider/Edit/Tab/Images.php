<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace InterSquad\Slider\Block\Adminhtml\Slider\Edit\Tab;

/**
 * Cms page edit form main tab
 */
class Images extends \Magento\Backend\Block\Widget\Form\Generic implements
    \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $_storeManager;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->_storeManager = $storeManager;
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('isa_slider');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('InterSquad_Slider::slider')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('isa_slider_');

        $fieldset = $form->addFieldset(
            'images_fieldset',
            ['legend' => __('Images'), 'class' => 'fieldset-wide']
        );
//        $fieldset->addField(
//            'images',
//            'image',
//            [
//                'name' => 'slider_image',
//                'label' => __('Image'),
//                'title' => __('Image'),
//                'disabled' => $isElementDisabled
//            ]
//        );

        $images = $model->getImages();
        if ($images) {
            $images = unserialize($images);
            foreach ($images as $key => $image) {
                $imgTitle = isset($image['title']) ? $image['title'] : '';
                $imgPath = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'inter_squad/sliders' . $image['path'];
                $model->setData($key, $imgPath);

                $fieldset->addField(
                    $key,
                    'image',
                    [
                        'name' => $key,
                        'label' => __($imgTitle),
                        'title' => __($imgTitle),
                        'disabled' => $isElementDisabled
                    ]
                );
            }
        }
//        $tmpData = array (
//            'image_1' => array(
//                'id' => 1,
//                'title' => 'Image 1',
//                'path' => '/fap/xxx.jpg'
//            ),
//            'image_2' => array(
//                'id' => 2,
//                'title' => 'Image 2',
//                'path' => '/fap/aaa.jpg'
//            )
//        );

//        $contentField = $fieldset->addField(
//            'content',
//            'editor',
//            [
//                'name' => 'content',
//                'style' => 'height:36em;',
//                'required' => true,
//                'disabled' => $isElementDisabled,
//                'config' => $wysiwygConfig
//            ]
//        );
//
//        // Setting custom renderer for content field to remove label column
//        $renderer = $this->getLayout()->createBlock(
//            'Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element'
//        )->setTemplate(
//            'Magento_Cms::page/edit/form/renderer/content.phtml'
//        );
//        $contentField->setRenderer($renderer);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Images');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Images');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
