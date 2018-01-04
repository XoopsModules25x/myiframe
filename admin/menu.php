<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

use XoopsModules\Myiframe;

require_once __DIR__ . '/../class/Helper.php';
//require_once __DIR__ . '/../include/common.php';
$helper = Myiframe\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

$adminmenu = [
    [
        'title' => _MI_MYIFRAME_NAME,
        'link'  => 'admin/index.php',
        'icon'  => $pathIcon32 . '/home.png'
    ],

    [
        'title' => _MI_MYIFRAME_ADMENU1,
        'link'  => 'admin/manage.php',
        'icon'  => $pathIcon32 . '/manage.png'
    ],

    // Category
    [
        'title' => _MI_MYIFRAME_ADMENU2,
        'link'  => 'admin/about.php',
        'icon'  => $pathIcon32 . '/about.png'
    ],
];
