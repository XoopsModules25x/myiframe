<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined.');

/**
 * Returns a module's option
 *
 * Return's a module's option (for the myiframe module)
 *
 * @package      Myiframe
 * @author       Instant Zero (http://www.instant-zero.com)
 * @copyright    Instant Zero (http://www.instant-zero.com)
 * @param string $option module option's name
 * @param string $repmodule
 * @return bool
 */
function myiframe_getmoduleoption($option, $repmodule = 'myiframe')
{
    global $xoopsModuleConfig, $xoopsModule;
    static $tbloptions = [];
    if (is_array($tbloptions) && array_key_exists($option, $tbloptions)) {
        return $tbloptions[$option];
    }

    $retval = false;
    if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
        if (isset($xoopsModuleConfig[$option])) {
            $retval = $xoopsModuleConfig[$option];
        }
    } else {
        /** @var \XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $module        = $moduleHandler->getByDirname($repmodule);
        /** @var \XoopsConfigHandler $configHandler */
        $configHandler = xoops_getHandler('config');
        if ($module) {
            $moduleConfig = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
            if (isset($moduleConfig[$option])) {
                $retval = $moduleConfig[$option];
            }
        }
    }
    $tbloptions[$option] = $retval;
    return $retval;
}

/**
 * Verify that a field exists inside a mysql table
 *
 * @package      Myiframe
 * @author       Instant Zero (http://www.instant-zero.com)
 * @copyright    Instant Zero (http://www.instant-zero.com)
 * @param $fieldname
 * @param $table
 * @return bool
 */
function myiframe_FieldExists($fieldname, $table)
{
    $result = $GLOBALS['xoopsDB']->queryF("SHOW COLUMNS FROM	$table LIKE '$fieldname'");
    return ($GLOBALS['xoopsDB']->getRowsNum($result) > 0);
}

/**
 * Set the page's title, meta description and meta keywords
 * Datas are supposed to be sanitized
 *
 * @package          Myiframe
 * @author           Instant Zero http://www.instant-zero.com
 * @copyright    (c) Instant Zero http://www.instant-zero.com
 *
 * @param string $page_title       Page's Title
 * @param string $meta_description Page's meta description
 * @param string $meta_keywords    Page's meta keywords
 * @return void
 */
function myiframe_set_metas($page_title = '', $meta_description = '', $meta_keywords = '')
{
    global $xoTheme, $xoTheme, $xoopsTpl;
    $xoopsTpl->assign('xoops_pagetitle', $page_title);
    if (isset($xoTheme) && is_object($xoTheme)) {
        if (!empty($meta_keywords)) {
            $xoTheme->addMeta('meta', 'keywords', $meta_keywords);
        }
        if (!empty($meta_description)) {
            $xoTheme->addMeta('meta', 'description', $meta_description);
        }
    } elseif (isset($xoopsTpl) && is_object($xoopsTpl)) {    // Compatibility for old Xoops versions
        if (!empty($meta_keywords)) {
            $xoopsTpl->assign('xoops_meta_keywords', $meta_keywords);
        }
        if (!empty($meta_description)) {
            $xoopsTpl->assign('xoops_meta_description', $meta_description);
        }
    }
}
