<?php
include  dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
include XOOPS_ROOT_PATH . '/include/cp_functions.php';
require_once XOOPS_ROOT_PATH . '/kernel/module.php';
include  dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
if ($xoopsUser) {
    $xoopsModule = XoopsModule::getByDirname('myiframe');
    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/', 3, _NOPERM);
    }
} else {
    redirect_header(XOOPS_URL . '/', 3, _NOPERM);
}

$myts = \MyTextSanitizer::getInstance();
