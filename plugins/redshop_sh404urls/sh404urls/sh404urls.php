<?php
/**
 * @package     Wonderliving
 * @subpackage  Plugin
 *
 * @copyright   Copyright (C) 2008 - 2017 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Plugins redSHOP Sidebar
 *
 * @since 1.0
 */
class PlgRedshop_Sh404urlsSh404urls extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @param    object $subject The object to observe
	 * @param    array  $config  An array that holds the plugin configuration
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * @param   $pids  array  products id
	 *
	 * @return  void
	 */
	public function onAfterProductDelete($pids)
	{
		foreach ($pids as $pid)
		{
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->clear()
			      ->delete($db->qn('#__sh404sef_urls'))
			      ->where($db->qn('newurl') . ' LIKE ' . $db->q('%view=product%'))
			      ->where($db->qn('newurl') . ' LIKE ' . $db->q('%option=com_redshop%'))
			      ->where($db->qn('newurl') . ' LIKE ' . $db->q('%pid=' . (int) $pid . '%'));

			$db->setQuery($query)->execute();
		}
	}
}
