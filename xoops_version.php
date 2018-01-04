<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

use Xmf\Request;

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined.');

include __DIR__ . '/preloads/autoloader.php';

$modversion = [
    'version'             => 1.66,
    'module_status'       => 'Beta 1',
    'release_date'        => '2017/08/04',
    'name'                => _MI_MYIFRAME_NAME,
    'description'         => _MI_MYIFRAME_DESC,
    'credits'             => '',
    'author'              => 'Instant Zero - http://xoops.instant-zero.com',
    'help'                => 'page=help',
    'license'             => 'GPL see LICENSE',
    'official'            => 0,
    'image'               => 'assets/images/logoModule.png',
    'dirname'             => basename(__DIR__),
    'min_php'             => '5.5',
    'min_db'              => ['mysql' => '5.5'],
    'min_xoops'           => '2.5.8+',
    'min_admin'           => '1.2',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS',
    'module_release'      => '05/07/2017',
    'system_menu'         => 1,
    //sql tables
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    'tables'              => [
        'myiframe'
    ],
    // Admin
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // Menu
    'hasMain'             => 1
];
// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_MYIFRAME_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_MYIFRAME_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_MYIFRAME_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_MYIFRAME_SUPPORT, 'link' => 'page=support'],
];
// Templates
$modversion['templates'] = [
    [
        'file'        => 'myiframe.tpl',
        'description' => 'Default template'
    ],
];

//Blocks
$modversion['blocks'][] = [
    'file'        => 'myiframe_iframe.php',
    'name'        => _MI_MYIFRAME_BNAME1,
    'description' => 'Shows an iframe in a block',
    'show_func'   => 'b_myiframe_iframe_show',
    'edit_func'   => 'b_myiframe_iframe_edit',
    'options'     => '0',
    'template'    => 'myiframe_block_show.tpl'
];
global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname'] && $xoopsModule->getVar('isactive')) {
    $i = 0;
    include_once XOOPS_ROOT_PATH . '/modules/myiframe/include/functions.php';
    $myts = \MyTextSanitizer::getInstance();
    if (myiframe_getmoduleoption('showinmenu')) {
        $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('myiframe') . ' ORDER BY frame_description';
        $result = $GLOBALS['xoopsDB']->query($sql);
        while (false !== ($myrow = $GLOBALS['xoopsDB']->fetchArray($result))) {
            if ('' !== xoops_trim($myrow['frame_description'])) {
                $modversion['sub'][$i]['name'] = $myts->htmlSpecialChars($myrow['frame_description']);
                $modversion['sub'][$i]['url']  = 'index.php?iframeid=' . (int)$myrow['frame_frameid'];
                $i++;
            }
        }
    }
}
// Options
$modversion['config'][] = [
    'name'        => 'showinmenu',
    'title'       => '_MI_MYIFRAME_OPT0',
    'description' => '_MI_MYIFRAME_OPT0_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
$modversion['config'][] = [
    'name'        => 'showlist',
    'title'       => '_MI_MYIFRAME_OPT1',
    'description' => '_MI_MYIFRAME_OPT1_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Search
$modversion['hasSearch'] = 0;
// Comments
$modversion['hasComments'] = 0;
// Notification
$modversion['hasNotification'] = 0;
