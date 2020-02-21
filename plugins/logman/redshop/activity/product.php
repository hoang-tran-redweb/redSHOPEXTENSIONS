<?php
/**
 * @package    LOGman
 * @copyright  Copyright (C) 2008 - 2015 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

/**
 * redSHOP LOGman plugin.
 *
 * @package  Joomlatools\Plugin\LOGman\Activity
 *
 * @since    1.0.0
 */
class PlgLogman\RedshopActivityProduct extends ComLogmanModelEntityActivity
{
	/**
	 * Init
	 *
	 * @param   KObjectConfig  $config  Config
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	protected function _initialize(KObjectConfig $config)
	{
		$config->append(
			array('format' => '{actor} {action} {object.type} name {object}')
		);

		parent::_initialize($config);
	}
}