<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
require_once JPATH_ROOT.'/plugins/system/st_megamenu/classes/menu.php';
$list = STMegaMenuClassMenu::getList($params);
// Note. It is important to remove spaces between elements.
?>
<?php // The menu class is deprecated. Use nav instead. ?>
<ul class="nav st-mega-menu menu <?php echo $class_sfx;?> clearfix"<?php
	$tag = '';
	if ($params->get('tag_id') != null)
	{
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) 
{
	if ($item->parent_id == 1) 
	{
		$class = 'item-'.$item->id;
		if ($item->id == $active_id)
		{
			$class .= ' current';
		}
	
		if (in_array($item->id, $path))
		{
			$class .= ' active';
		}
		elseif ($item->type == 'alias')
		{
			$aliasToId = $item->params->get('aliasoptions');
			if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
			{
				$class .= ' active';
			}
			elseif (in_array($aliasToId, $path))
			{
				$class .= ' alias-parent-active';
			}
		}
	
		if ($item->type == 'separator')
		{
			$class .= ' divider';
		}
	
		if ($item->deeper)
		{
			$class .= ' deeper';
		}
	
		if ($item->parent)
		{
			$class .= ' parent';
		}
	
		if (!empty($class))
		{
			$class = ' class="'.trim($class) .'"';
		}
		
		echo '<li'.$class.'>';
		// Render the menu item.
		switch ($item->type) :
			case 'separator':
			case 'url':
			case 'component':
			case 'heading':
				require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
				break;
	
			default:
				require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
				break;
		endswitch;
		echo STMegaMenuClassMenu::renderSubs($item, $path, $active_id);
		echo '</li>';	
	}
}


?></ul>
