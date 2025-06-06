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

namespace Cytracon\NinjaMenus\Block\Widget;

class Menu extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'widget/menu.phtml';

    /**
     * @var \Cytracon\NinjaMenus\Helper\Data
     */
    protected $menuHelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context    
     * @param \Cytracon\NinjaMenus\Helper\Menu                  $menuHelper 
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Cytracon\NinjaMenus\Helper\Menu $menuHelper
    ) {
        parent::__construct($context);
        $this->menuHelper = $menuHelper;
    }

    /**
     * @return string|null
     */
    public function getMenuHtml()
    {
        return $this->menuHelper->getMenuHtml($this->getIdentifier());
    }
}
