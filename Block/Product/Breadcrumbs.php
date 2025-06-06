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

namespace Cytracon\NinjaMenus\Block\Product;

class Breadcrumbs extends \Magento\Catalog\Block\Product\View
{
    /**
     * @var string
     */
    protected $_template = 'Cytracon_NinjaMenus::product/breadcrumbs.phtml';

    /**
     * @return array
     */
    public function getCategories()
    {
        $list     = [];
        $product  = $this->getProduct();
        $category = $product->getCategory();
        if ($category) {
            $categories = $category->getParentCategories();
            foreach ($categories as $_category) {
                $list[] = [
                    'label' => $_category->getName(),
                    'title' => $_category->getName(),
                    'link'  => $_category->getUrl()
                ];
            }
        }
        return $list;
    }
}