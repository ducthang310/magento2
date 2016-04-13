<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace InterSquad\Slider\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var fileUploaderFactory
     */
    protected $_fileUploaderFactory;
    protected $_directoryList;

    /**
     * @param Action\Context $context
     */
    public function __construct(Action\Context $context, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Magento\Framework\App\Filesystem\DirectoryList $directoryList)
    {
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_directoryList = $directoryList;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('InterSquad_Slider::slider');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('InterSquad\Slider\Model\Slider');

            $id = $this->getRequest()->getParam('slider_id');
            if ($id) {
                $model->load($id);
            }

            $images = $this->_uploadImage();
            $oldImages = unserialize($model->getImages());
            foreach ($images as $key => $image) {
                if ($image['type'] == 'no_change') {
                    if (isset($oldImages[$key])) {
                        $images[$key]['path'] = $oldImages[$key]['path'];
                    } else {
                        unset($images[$key]);
                    }
                }
                unset($images[$key]['type']);
            }

            $model->setData($data);
            $model->setData('images', serialize($images));

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this slider.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['slider_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the slider.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['slider_id' => $this->getRequest()->getParam('slider_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function _uploadImage()
    {
        $images = array();

        foreach ($_FILES as $key => $file) {
            if (!$file['name'] && !$file['type']) {
                $images[$key]['type'] = 'no_change';
                continue;
            }
            $uploader = $this->_fileUploaderFactory->create(['fileId' => $key]);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $uploader->setAllowRenameFiles(false);
            $uploader->setAllowCreateFolders(true);
            $uploader->setFilesDispersion(true);

            $path = $this->_directoryList->getPath('media') . '/inter_squad/sliders/';

            $result = $uploader->save($path);
            $images[$key]['path'] = $result['file'];
            $images[$key]['type'] = 'new';
        }

        return $images;
    }
}
