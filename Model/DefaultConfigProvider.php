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

namespace Cytracon\NinjaMenus\Model;

class DefaultConfigProvider extends \Cytracon\Builder\Model\DefaultConfigProvider
{
    /**
     * @var string
     */
    protected $_builderArea = 'menu';

    /**
     * @return array
     */
    public function getConfig()
    {
        $config = parent::getConfig();
        $config['profile'] = [
            'builder'          => \Cytracon\NinjaMenus\Block\Builder::class,
            'home'             => 'https://cytracon.com/magento-2-mega-menu.html?utm_campaign=mgzbuilder&utm_source=mgz_user&utm_medium=backend',
            'templateUrl'      => 'https://www.cytracon.com/productfile/ninjamenus/templates.php',
            'importCategories' => [
                'class' => \Cytracon\NinjaMenus\Data\Modal\ImportCategories::class
            ]
        ];
        $config['historyLabels']['imported_categories'] = __('Imported Categories');
        return $config;
    }
}
