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

namespace Cytracon\NinjaMenus\Helper;

class Menu extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * @var \Magento\Framework\Filter\FilterManager
     */
    protected $filterManager;

    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $layout;

    /**
     * @var \Cytracon\Core\Helper\Data
     */
    protected $coreHelper;

    /**
     * @var \Cytracon\Builder\Model\CacheManager
     */
    protected $cacheManager;

    /**
     * @var \Cytracon\NinjaMenus\Model\MenuFactory
     */
    protected $menuFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context      $context       
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager  
     * @param \Magento\Framework\App\ResourceConnection  $resource      
     * @param \Magento\Framework\Filter\FilterManager    $filterManager 
     * @param \Magento\Framework\View\LayoutInterface    $layout        
     * @param \Cytracon\Core\Helper\Data                  $coreHelper    
     * @param \Cytracon\Builder\Model\CacheManager        $cacheManager  
     * @param \Cytracon\NinjaMenus\Model\MenuFactory      $menuFactory   
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Filter\FilterManager $filterManager,
        \Magento\Framework\View\LayoutInterface $layout,
        \Cytracon\Core\Helper\Data $coreHelper,
        \Cytracon\Builder\Model\CacheManager $cacheManager,
        \Cytracon\NinjaMenus\Model\MenuFactory $menuFactory
    ) {
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->_resource     = $resource;
        $this->filterManager = $filterManager;
        $this->layout        = $layout;
        $this->coreHelper    = $coreHelper;
        $this->cacheManager  = $cacheManager;
        $this->menuFactory   = $menuFactory;
    }

    /**
     * @return \Cytracon\NinjaMenus\Model\Menu
     */
    protected function prepareMenu($menu)
    {
        $menu->setCreationTime(null);
        $menu->setUpdateTime(null);
        $menu->setId(null);
        return $menu;
    }

    /**
     * @param  string $value 
     * @param  string $field 
     * @return \Cytracon\NinjaMenus\Model\Menu
     */
    public function loadMenu($value, $field = 'identifier', $skipValid = false)
    {
        $menu = $this->menuFactory->create();
        if (!$this->_storeManager->isSingleStoreMode()) {
            $storeId = $this->_storeManager->getStore()->getId();
            $menu->setStoreId($storeId);
        }
        $menu->load($value, $field);
        return $menu;
    }

    /**
     * @return \Cytracon\NinjaMenus\Model\Menu
     */
    public function duplicateMenu($menu, $extendData = [])
    {
        $newForm = $this->menuFactory->create();
        $data = array_merge($menu->getData(), $extendData);
        $newForm->setData($data);
        $this->prepareMenu($newForm);
        $newIdentifier = $this->generateIdentifier($menu->getIdentifier());
        $newForm->setIdentifier($newIdentifier);
        $newForm->save();
        return $newForm;
    }

    /**
     * @param  \Cytracon\NinjaMenus\Model\Menu $objct
     * @return string
     */
    protected function generateIdentifier($identifier)
    {
        $table      = $this->_resource->getTableName('mgz_ninjamenus_menu');
        $identifier = $this->filterManager->translitUrl($identifier);
        $connection = $this->_resource->getConnection();
        $select     = $connection->select()->from($table);
        $menus      = $connection->fetchAll($select);
        $x          = 1;
        while (true) {
            $validate = true;
            foreach ($menus as $_menu) {
                if ($identifier === $_menu['identifier']) {
                    $validate   = false;
                    $identifier = $identifier . $x;
                    $x++;
                }
            }
            if ($validate) {
                break;
            }
        }

        return $identifier;
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        $templates = [];
        try {
            $key = 'NINJAMENS_TEMPLATES';
            $templates = $this->cacheManager->getFromCache($key);
            if ($templates) {
                return $this->coreHelper->unserialize($templates);
            }
            $url = 'https://www.cytracon.com/productfile/ninjamenus/templates.json';
            $ch  = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch);
            curl_close($ch);
            if ($content) {
                $templates = $this->coreHelper->unserialize($content);

                $newTemplates = [];
                foreach ($templates as $template) {
                    try {
                        $newTemplates[] = $template;
                    } catch (\Exception $e) {
                    }
                }
                $templates = $newTemplates;
            }
            $this->cacheManager->saveToCache($key, $templates);
        } catch (\Exception $e) {

        }
        return $templates;
    }

    /**
     * @param  string $identifier 
     * @return string             
     */
    public function getMenuHtml($identifier, $customClasses = '')
    {
        return $this->layout->createBlock('\Cytracon\NinjaMenus\Block\Menu')->setCustomClasses($customClasses)->setIdentifier($identifier)->toHtml();
    }
}
