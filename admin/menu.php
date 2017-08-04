<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */
if (!isset($moduleDirName)) {
    $moduleDirName = basename(dirname(__DIR__));
}

if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}
$adminObject   = \Xmf\Module\Admin::getInstance();
$pathIcon32    = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $moduleHelper->getModule()->getInfo('modicons32');
$moduleHelper->loadLanguage('modinfo');
$moduleHelper->loadLanguage('admin');

$adminmenu = array(
    array(
        'title' => _MI_MYIFRAME_NAME,
        'link'  => 'admin/index.php',
        'icon'  => $pathIcon32 . '/home.png'
    ),

    array(
        'title' => _MI_MYIFRAME_ADMENU1,
        'link'  => 'admin/manage.php',
        'icon'  => $pathIcon32 . '/manage.png'
    ),

    // Category
    array(
        'title' => _MI_MYIFRAME_ADMENU2,
        'link'  => 'admin/about.php',
        'icon'  => $pathIcon32 . '/about.png'
    ),
);
