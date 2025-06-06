<?php
/**
 * Cytracon
 *
 * This source file is subject to the Cytracon Software License, which is available at https://www.cytracon.com/license
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to https://www.cytracon.com for more inmenuation.
 *
 * @category  Cytracon
 * @package   Cytracon_NinjaMenus
 * @copyright Copyright (C) 2019 Cytracon (https://www.cytracon.com)
 */

namespace Cytracon\NinjaMenus\Block\Adminhtml;

class TopMenu extends \Cytracon\Core\Block\Adminhtml\TopMenu
{
    /**
     * Init menu items
     *
     * @return array
     */
    public function intLinks()
    {
        $links = [
            [
                [
                    'title'    => __('Add New Menu'),
                    'link'     => $this->getUrl('ninjamenus/menu/new'),
                    'resource' => 'Cytracon_NinjaMenus::menu_save'
                ],
                [
                    'title'    => __('Manage Menus'),
                    'link'     => $this->getUrl('ninjamenus/menu'),
                    'resource' => 'Cytracon_NinjaMenus::menu'
                ],
                [
                    'title'    => __('Settings'),
                    'link'     => $this->getUrl('adminhtml/system_config/edit/section/ninjamenus'),
                    'resource' => 'Cytracon_NinjaMenus::settings'
                ]
            ],
            [
                'class' => 'separator'
            ],
            [
                'title'  => __('User Guide'),
                'link'   => 'https://cytracon.com/pub/media/productfile/ninjamenus2-installation-guides.pdf',
                'target' => '_blank'
            ],
            [
                'title'  => __('Change Log'),
                'link'   => 'https://www.cytracon.com/magento-2-mega-menu.html#release_notes',
                'target' => '_blank'
            ],
            [
                'title'  => __('Get Support'),
                'link'   => $this->getSupportLink(),
                'target' => '_blank'
            ]
        ];
        return $links;
    }
}
