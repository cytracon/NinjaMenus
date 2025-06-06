<?php
/**
 * Cytracon
 *
 * This source file is subject to the Cytracon Software License, which is available at https://www.cytracon.com/license
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to https://www.cytracon.com for more information.
 *
 * @category  Cytracon
 * @package   Cytracon_NinjaMenus
 * @copyright Copyright (C) 2018 Cytracon (https://www.cytracon.com)
 */

namespace Cytracon\NinjaMenus\Block\Adminhtml;

class Scripts extends \Magento\Backend\Block\Template
{
    /**
     * @var \Cytracon\Core\Model\Source\Categories
     */
    protected $categories;

    /**
     * @param \Magento\Backend\Block\Template\Context $context    
     * @param \Cytracon\Core\Model\Source\Categories   $categories 
     * @param array                                   $data       
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Cytracon\Core\Model\Source\Categories $categories,
        array $data = []
    ) {
        parent::__construct($context);
        $this->categories = $categories;
    }

    /**
     * @return array
     */
    public function getStoreCategories()
    {
        return $this->categories->getCategoriesTree();
    }
}
