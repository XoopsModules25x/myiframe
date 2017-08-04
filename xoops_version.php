<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

use Xmf\Request;

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

$modversion = array(
    'name'                => _MI_MYIFRAME_NAME,
    'version'             => 1.65,
    'description'         => _MI_MYIFRAME_DESC,
    'credits'             => '',
    'author'              => 'Instant Zero - http://xoops.instant-zero.com',
    'help'                => '',
    'license'             => 'GPL see LICENSE',
    'official'            => 0,
    'image'               => 'assets/images/myiframe.png',
    'dirname'             => 'myiframe',
    'min_php'             => '5.5',
    'min_db'              => array('mysql' => '5.5'),
    'min_xoops'           => '2.5.8+',
    'min_admin'           => '1.2',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS',
    'module_release'      => '05/07/2017',
    'release_date'        => '2017/07/05',
    'module_status'       => 'Test',
    'system_menu'         => 1,
    //sql tables
    'sqlfile'             => array('mysql' => 'sql/mysql.sql'),
    'tables'              => array(
        'myiframe'
    ),
    // Admin
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // Menu
    'hasMain'             => 1
);

// Templates
$modversion['templates'] = array(
    array(
        'file'        => 'myiframe.tpl',
        'description' => 'Default template'
    ),
);

//Blocks
$modversion['blocks'][] = array(
    'file'        => 'myiframe_iframe.php',
    'name'        => _MI_MYIFAME_BNAME1,
    'description' => 'Shows an iframe in a block',
    'show_func'   => 'b_myiframe_iframe_show',
    'edit_func'   => 'b_myiframe_iframe_edit',
    'options'     => '0',
    'template'    => 'myiframe_block_show.tpl'
);

global $xoopsDB, $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname'] && $xoopsModule->getVar('isactive')) {
    $i = 0;
    include_once XOOPS_ROOT_PATH . '/modules/myiframe/include/functions.php';
    $myts = MyTextSanitizer::getInstance();
    if (myiframe_getmoduleoption('showinmenu')) {
        $sql    = 'SELECT * FROM ' . $xoopsDB->prefix('myiframe') . ' ORDER BY frame_description';
        $result = $xoopsDB->query($sql);
        while ($myrow = $xoopsDB->fetchArray($result)) {
            if (xoops_trim($myrow['frame_description']) != '') {
                $modversion['sub'][$i]['name'] = $myts->htmlSpecialChars($myrow['frame_description']);
                $modversion['sub'][$i]['url']  = 'index.php?iframeid=' . (int)$myrow['frame_frameid'];
                $i++;
            }
        }
    }
}

// Options
$i                                      = 1;
$modversion['config'][1]['name']        = 'showinmenu';
$modversion['config'][1]['title']       = '_MI_MYIFRAME_OPT0';
$modversion['config'][1]['description'] = '_MI_MYIFRAME_OPT0_DSC';
$modversion['config'][1]['formtype']    = 'yesno';
$modversion['config'][1]['valuetype']   = 'int';
$modversion['config'][1]['default']     = 0;
$i++;
$modversion['config'][2]['name']        = 'showlist';
$modversion['config'][2]['title']       = '_MI_MYIFRAME_OPT1';
$modversion['config'][2]['description'] = '_MI_MYIFRAME_OPT1_DSC';
$modversion['config'][2]['formtype']    = 'yesno';
$modversion['config'][2]['valuetype']   = 'int';
$modversion['config'][2]['default']     = 1;

// Search
$modversion['hasSearch'] = 0;

// Comments
$modversion['hasComments'] = 0;

// Notification
$modversion['hasNotification'] = 0;
