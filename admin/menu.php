<?php declare(strict_types=1);

/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (https://www.instant-zero.com)
 * ****************************************************************************
 */

use Xmf\Module\Admin;
use XoopsModules\Myiframe;

/** @var Myiframe\Helper $helper */
$moduleDirName      = \basename(\dirname(__DIR__));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

$helper = Myiframe\Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32    = Admin::menuIconPath('');
$pathModIcon32 = XOOPS_URL . '/modules/' . $moduleDirName . '/assets/images/icons/32/';
if (is_object($helper->getModule())
    && false !== $helper->getModule()
                        ->getInfo('modicons32')) {
    $pathModIcon32 = $helper->url(
        $helper->getModule()
               ->getInfo('modicons32')
    );
}

$adminmenu[] = [
    'title' => _MI_MYIFRAME_NAME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_MYIFRAME_ADMENU1,
    'link'  => 'admin/manage.php',
    'icon'  => $pathIcon32 . '/manage.png',
];

// Blocks Admin
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link'  => 'admin/blocksadmin.php',
    'icon'  => $pathIcon32 . '/block.png',
];

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link'  => 'admin/migrate.php',
        'icon'  => $pathIcon32 . '/database_go.png',
    ];
}

// Category
$adminmenu[] = [
    'title' => _MI_MYIFRAME_ADMENU2,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',

];
