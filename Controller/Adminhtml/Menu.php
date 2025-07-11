<?php
/**
 * Cytracon
 *
 * This source file is subject to the Cytracon Software License, which is available at https://www.cytracon.com/license.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to https://www.cytracon.com for more information.
 *
 * @category  Cytracon
 * @package   Cytracon_NinjaMenus
 * @copyright Copyright (C) 2019 Cytracon (https://www.cytracon.com)
 */

namespace Cytracon\NinjaMenus\Controller\Adminhtml;

abstract class Menu extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Cytracon_NinjaMenus::menu';

    /**
     * Initialize requested menu and put it into registry.
     *
     * @return \Cytracon\NinjaMenus\Model\Menu|false
     */
    protected function _initMenu()
    {
        $menuId  = $this->resolveMenuId();
        $storeId = (int)$this->getRequest()->getParam('store');
        $menu    = $this->_objectManager->create(\Cytracon\NinjaMenus\Model\Menu::class);
        $menu->setStoreId($storeId);

        if ($menuId) {
            $menu->load($menuId);
        }

        $menuData = $this->_getSession()->getBuilderFormData(true);
        if (is_array($menuData)) {
            $menu->addData($menuData);
        }

        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('menu', $menu);
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('current_menu', $menu);
        $this->_objectManager->get(\Magento\Cms\Model\Wysiwyg\Config::class)->setStoreId($storeId);
        return $menu;
    }

    /**
     * Resolve Menu Id (from get or from post)
     *
     * @return int
     */
    private function resolveMenuId()
    {
        $menuId = (int) $this->getRequest()->getParam('id', false);
        return $menuId ?: (int) $this->getRequest()->getParam('menu_id', false);
    }
}
