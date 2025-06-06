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

namespace Cytracon\NinjaMenus\Ui\DataProvider\Menu;

use Cytracon\NinjaMenus\Model\ResourceModel\Menu\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class FormDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    const META_CONFIG_PATH = '/arguments/data/config';

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var \Cytracon\NinjaMenus\Model\ResourceModel\Menu\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Cytracon\Core\Helper\Data
     */
    protected $coreHelper;

    /**
     * @var \Cytracon\Builder\Helper\Data
     */
    protected $builderHelper;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var PoolInterface
     */
    protected $pool;

    /**
     * @param string                                  $name
     * @param string                                  $primaryFieldName
     * @param string                                  $requestFieldName
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\App\RequestInterface $request
     * @param CollectionFactory                       $menuCollectionFactory
     * @param DataPersistorInterface                  $dataPersistor
     * @param \Cytracon\Core\Helper\Data               $coreHelper
     * @param \Cytracon\Builder\Helper\Data            $builderHelper
     * @param PoolInterface                           $pool
     * @param array                                   $meta
     * @param array                                   $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\RequestInterface $request,
        CollectionFactory $menuCollectionFactory,
        DataPersistorInterface $dataPersistor,
        \Cytracon\Core\Helper\Data $coreHelper,
        \Cytracon\Builder\Helper\Data $builderHelper,
        PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        $this->collection    = $menuCollectionFactory->create();
        $this->registry      = $registry;
        $this->dataPersistor = $dataPersistor;
        $this->request       = $request;
        $this->coreHelper    = $coreHelper;
        $this->builderHelper = $builderHelper;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
        $this->pool = $pool;
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $menu = $this->getCurrentMenu();
        if ($menu && $menu->getId()) {
            $menuData = $menu->getData();

            /** @var ModifierInterface $modifier */
            foreach ($this->pool->getModifiersInstances() as $modifier) {
                $menuData = $modifier->modifyData($menuData);
            }
            $this->loadedData[$menu->getId()] = $menuData;
        }

        $data = $this->dataPersistor->get('current_menu');
        if (!empty($data)) {
            $menu = $this->collection->getNewEmptyItem();
            $menu->setData($data);
            $this->loadedData[$menu->getId()] = $menu->getData();
            $this->dataPersistor->clear('current_menu');
        }
        return $this->loadedData;
    }

    /**
     * {@inheritdoc}
     * @since 101.0.0
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        $meta = $this->prepareMeta($meta);
        $menu = $this->getCurrentMenu();
        $meta = $this->generatedUrlKey($meta, 'identifier');

        return $meta;
    }


    /**
     * Get current form
     *
     * @return \Cytracon\NinjaMenus\Model\Form
     */
    public function getCurrentMenu()
    {
        return $this->registry->registry('current_menu');
    }

    /**
     * Add links for fields depends of product name
     *
     * @param array $meta
     * @return array
     */
    protected function generatedUrlKey($meta, $urlKey = 'identifier', $name = 'name')
    {
        $listenerPath  = $this->builderHelper->getArrayManager()->findPath($urlKey, $meta, null, 'children');
        $importsConfig = [
            'mask'        => '{{name}}',
            'component'   => 'Cytracon_Core/js/components/generated-urlkey',
            'allowImport' => !$this->getCurrentMenu()->getId(),
            'elementTmpl' => 'ui/form/element/input'
        ];

        $meta       = $this->builderHelper->getArrayManager()->merge($listenerPath . static::META_CONFIG_PATH, $meta, $importsConfig);
        $urlKeyPath = $this->builderHelper->getArrayManager()->findPath($urlKey, $meta, null, 'children');

        $meta = $this->builderHelper->getArrayManager()->merge(
            $urlKeyPath . static::META_CONFIG_PATH,
            $meta,
            [
                'autoImportIfEmpty' => true
            ]
        );

        $namePath = $this->builderHelper->getArrayManager()->findPath($name, $meta, null, 'children');

        return $this->builderHelper->getArrayManager()->merge(
            $namePath . static::META_CONFIG_PATH,
            $meta,
            [
                'valueUpdate' => 'keyup'
            ]
        );
    }
}
