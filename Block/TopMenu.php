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

namespace Cytracon\NinjaMenus\Block;

class TopMenu extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Cytracon\NinjaMenus\Helper\Data
     */
    protected $menuHelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context    
     * @param \Cytracon\NinjaMenus\Helper\Menu                  $menuHelper 
     * @param array                                            $data       
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Cytracon\NinjaMenus\Helper\Menu $menuHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->menuHelper = $menuHelper;
    }

    public function getMenuHtml()
    {
        return $this->menuHelper->getMenuHtml($this->getIdentifier(), 'ninjamenus-top');
    }

    public function getMagentoTopMenuHtml()
    {
        $block = $this->getLayout()->createBlock(\Magento\Theme\Block\Html\Topmenu::class);
        $block->setTemplate('Magento_Theme::html/topmenu.phtml');
        return $block->toHtml();
    }
}
