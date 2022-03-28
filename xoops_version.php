<?php declare(strict_types=1);

/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (https://www.instant-zero.com)
 * ****************************************************************************
 */
defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined.');

require_once __DIR__ . '/preloads/autoloader.php';

$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

$modversion = [
    'version'             => '1.67.0',
    'module_status'       => 'Beta 2',
    'release_date'        => '2022/03/28',
    'name'                => _MI_MYIFRAME_NAME,
    'description'         => _MI_MYIFRAME_DESC,
    'credits'             => '',
    'author'              => 'Instant Zero - https://xoops.instant-zero.com',
    'help'                => 'page=help',
    'license'             => 'GPL see LICENSE',
    'official'            => 0,
    'image'               => 'assets/images/logoModule.png',
    'dirname'             => basename(__DIR__),
    'min_php'             => '7.4',
    'min_db'              => ['mysql' => '5.5'],
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS',
    'module_release'      => '03/28/2022',
    'system_menu'         => 1,
    //sql tables
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    'tables'              => [
        'myiframe',
    ],
    // Admin
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // Menu
    'hasMain'             => 1,
];
// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_MYIFRAME_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_MYIFRAME_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_MYIFRAME_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_MYIFRAME_SUPPORT, 'link' => 'page=support'],
];
// ------------------- Templates ------------------- //
$modversion['templates'] = [
    ['file' => 'myiframe.tpl', 'description' => 'Default template'],
];

//Blocks
$modversion['blocks'][] = [
    'file'        => 'myiframe_iframe.php',
    'name'        => _MI_MYIFRAME_BNAME1,
    'description' => 'Shows an iframe in a block',
    'show_func'   => 'b_myiframe_iframe_show',
    'edit_func'   => 'b_myiframe_iframe_edit',
    'options'     => '0',
    'template'    => 'myiframe_block_show.tpl',
];
global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname'] && $xoopsModule->getVar('isactive')) {
    $i = 0;
    require_once XOOPS_ROOT_PATH . '/modules/myiframe/include/functions.php';
    $myts = \MyTextSanitizer::getInstance();
    if (myiframe_getmoduleoption('showinmenu')) {
        $sql    = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('myiframe') . ' ORDER BY frame_description';
        $result = $GLOBALS['xoopsDB']->query($sql);
        while (false !== ($myrow = $GLOBALS['xoopsDB']->fetchArray($result))) {
            if ('' !== xoops_trim($myrow['frame_description'])) {
                $modversion['sub'][$i]['name'] = htmlspecialchars($myrow['frame_description']);
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

// Make Sample button visible?
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Maintained by
$modversion['config'][] = [
    'name'        => 'maintainedby',
    'title'       => '\_MI_MYMODULE_MAINTAINEDBY',
    'description' => '\_MI_MYMODULE_MAINTAINEDBY_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'https://xoops.org/modules/newbb',
];

// Search
$modversion['hasSearch'] = 0;
// Comments
$modversion['hasComments'] = 0;
// Notification
$modversion['hasNotification'] = 0;
