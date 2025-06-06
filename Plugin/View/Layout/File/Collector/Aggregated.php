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

namespace Cytracon\NinjaMenus\Plugin\View\Layout\File\Collector;

class Aggregated
{
	/**
	 * @var \Cytracon\NinjaMenus\Helper\Data
	 */
	protected $dataHelper;

	/**
	 * @param \Cytracon\NinjaMenus\Helper\Data $dataHelper
	 */
	public function __construct(
		\Cytracon\NinjaMenus\Helper\Data $dataHelper
	) {
		$this->dataHelper = $dataHelper;
	}

	public function afterGetFiles(
		$subject,
		$result
	) {
		if (!$this->dataHelper->isEnabled()) {
			foreach ($result as $k => $file) {
				if (strpos($file->getFilename(), 'Cytracon/NinjaMenus') !== FALSE) {
					unset($result[$k]);
				}
			}
		}
		return $result;
    }
}