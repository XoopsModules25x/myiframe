<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

/**
 * Returns a module's option
 *
 * Return's a module's option (for the myiframe module)
 *
 * @package Myiframe
 * @author Instant Zero (http://www.instant-zero.com)
 * @copyright	Instant Zero (http://www.instant-zero.com)
 * @param string $option	module option's name
 */
function myiframe_getmoduleoption($option, $repmodule='myiframe')
{
	global $xoopsModuleConfig, $xoopsModule;
	static $tbloptions= array();
	if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
		return $tbloptions[$option];
	}

	$retval=false;
	if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
		if(isset($xoopsModuleConfig[$option])) {
			$retval= $xoopsModuleConfig[$option];
		}
	} else {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($repmodule);
		$config_handler =& xoops_gethandler('config');
		if ($module) {
		    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	    	if(isset($moduleConfig[$option])) {
	    		$retval= $moduleConfig[$option];
	    	}
		}
	}
	$tbloptions[$option]=$retval;
	return $retval;
}

/**
 * Verify that a field exists inside a mysql table
 *
 * @package Myiframe
 * @author Instant Zero (http://www.instant-zero.com)
 * @copyright	Instant Zero (http://www.instant-zero.com)
 */
function myiframe_FieldExists($fieldname,$table)
{
	global $xoopsDB;
	$result=$xoopsDB->queryF("SHOW COLUMNS FROM	$table LIKE '$fieldname'");
	return($xoopsDB->getRowsNum($result) > 0);
}

/**
 * Set the page's title, meta description and meta keywords
 * Datas are supposed to be sanitized
 *
 * @package Myiframe
 * @author Instant Zero http://www.instant-zero.com
 * @copyright	(c) Instant Zero http://www.instant-zero.com
 *
 * @param string $page_title	Page's Title
 * @param string $meta_description	Page's meta description
 * @param string $meta_keywords	Page's meta keywords
 * @return none
 */
function myiframe_set_metas($page_title = '', $meta_description = '', $meta_keywords = '')
{
	global $xoTheme, $xoTheme, $xoopsTpl;
	$xoopsTpl->assign('xoops_pagetitle', $page_title);
	if(isset($xoTheme) && is_object($xoTheme)) {
		if(!empty($meta_keywords)) {
			$xoTheme->addMeta( 'meta', 'keywords', $meta_keywords);
		}
		if(!empty($meta_description)) {
			$xoTheme->addMeta( 'meta', 'description', $meta_description);
		}
	} elseif(isset($xoopsTpl) && is_object($xoopsTpl)) {	// Compatibility for old Xoops versions
		if(!empty($meta_keywords)) {
			$xoopsTpl->assign('xoops_meta_keywords', $meta_keywords);
		}
		if(!empty($meta_description)) {
			$xoopsTpl->assign('xoops_meta_description', $meta_description);
		}
	}
}
?>