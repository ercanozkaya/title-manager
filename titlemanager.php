<?php
/**
 * @package		Title Manager
 * @copyright	(C) 2008 - 2011 Ercan Ozkaya. All rights reserved.
 * @license     GNU GPL <http://www.gnu.org/licenses/gpl.html>
 * @author		Ercan Ozkaya <ozkayaercan@gmail.com>
 */

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemTitlemanager extends JPlugin
{
	public function onAfterDispatch()
	{
		$app = JFactory::getApplication();
		if ($app->isAdmin()) {
			return;
		}

		$document = JFactory::getDocument();
		$menu = JSite::getMenu();
		$params = $this->params;
		$is_frontpage = ($menu->getActive() == $menu->getDefault());
		
		$sitename = $params->get('sitename') ? $params->get('sitename') : $app->getCfg('sitename');
		if ($is_frontpage) {
			if ($params->get('frontpage_sitename')) {
				$sitename = $params->get('frontpage_sitename');
			}
			
			if ($params->get('frontpage') == '1') {
				return $document->setTitle($sitename);
			}
		}

		// {s} is used to protect the leading and trailing spaces
		$separator = str_replace('{s}', ' ', $params->get('separator'));
		$current = $document->getTitle();

		if ($params->get('position') == 'after') {
			$title = $current.$separator.$sitename;
		} else {
			$title = $sitename.$separator.$current;
		}

		$document->setTitle($title);
	}
}