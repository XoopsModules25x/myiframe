<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

$modversion['name'] = _MI_MYIFRAME_NAME;
$modversion['version'] = 1.6;
$modversion['description'] = _MI_MYIFRAME_DESC;
$modversion['credits'] = "";
$modversion['author'] = 'Instant Zero - http://xoops.instant-zero.com';
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = "0";
$modversion['image'] = "images/myiframe.png";
$modversion['dirname'] = "myiframe";

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "myiframe";

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;

// Templates
$modversion['templates'][1]['file'] = 'myiframe.html';
$modversion['templates'][1]['description'] = 'Default template';

// Blocks
$modversion['blocks'][1]['file'] = 'myiframe_iframe.php';
$modversion['blocks'][1]['name'] = _MI_MYIFAME_BNAME1;
$modversion['blocks'][1]['description'] = "Shows an iframe in a block";
$modversion['blocks'][1]['show_func'] = "b_myiframe_iframe_show";
$modversion['blocks'][1]['edit_func'] = "b_myiframe_iframe_edit";
$modversion['blocks'][1]['template'] = 'myiframe_block_show.html';
$modversion['blocks'][1]['options'] = '0';

// Search
$modversion['hasSearch'] = 0;

// Comments
$modversion['hasComments'] = 0;

// Notification
$modversion['hasNotification'] = 0;

global $xoopsDB, $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

if(is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname'] && $xoopsModule->getVar('isactive')) {
    $i = 0;
    include_once XOOPS_ROOT_PATH.'/modules/myiframe/include/functions.php';
    $myts =& MyTextSanitizer::getInstance();
    if(myiframe_getmoduleoption('showinmenu')) {
        $sql = "SELECT * FROM ".$xoopsDB->prefix('myiframe')." ORDER BY frame_description";
        $result = $xoopsDB->query($sql);
        while($myrow = $xoopsDB->fetchArray($result)) {
            if(xoops_trim($myrow['frame_description'])!='') {
                $modversion['sub'][$i]['name'] = $myts->htmlSpecialChars($myrow['frame_description']);
                $modversion['sub'][$i]['url'] = 'index.php?iframeid='.intval($myrow['frame_frameid']);
                $i++;
            }
        }
    }
}

// Options
$modversion['config'][1]['name'] = 'showinmenu';
$modversion['config'][1]['title'] = '_MI_MYIFRAME_OPT0';
$modversion['config'][1]['description'] = '_MI_MYIFRAME_OPT0_DSC';
$modversion['config'][1]['formtype'] = 'yesno';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 0;

$modversion['config'][2]['name'] = 'showlist';
$modversion['config'][2]['title'] = '_MI_MYIFRAME_OPT1';
$modversion['config'][2]['description'] = '_MI_MYIFRAME_OPT1_DSC';
$modversion['config'][2]['formtype'] = 'yesno';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = 1;

?>
