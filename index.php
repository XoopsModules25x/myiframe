<?php declare(strict_types=1);

/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (https://www.instant-zero.com)
 * ****************************************************************************
 */

use Xmf\Request;

/** @var Helper $helper */

$GLOBALS['xoopsOption']['template_main'] = 'myiframe.tpl';
require __DIR__ . '/header.php';
require_once XOOPS_ROOT_PATH . '/header.php';

$tblalign = [];

$suplparam = '';
if (isset($_GET)) {
    foreach ($_GET as $k => $v) {
        if ('IFRAMEID' !== \mb_strtoupper(trim($k))) {
            $suplparam .= $k . '=' . $v . '&';
        }
    }
}

if (mb_strlen(xoops_trim($suplparam)) > 0) {
    $suplparam = mb_substr($suplparam, 0, -1);
}

/** @var \MyiframeBaseHandler $iframeHandler */
$iframeHandler = $helper->getHandler('MyiframeBase');

if (Request::hasVar('iframeid', 'GET')) {
    $tblalign     = [
        'top',
        'middle',
        'bottom',
        'left',
        'rigth',
    ];
    $tblscrolling = [
        'yes',
        'no',
        'auto',
    ];
    $frameid      = Request::getInt('iframeid', 0, 'GET');

    $frame = $iframeHandler->get($frameid);

    if (is_object($frame)) {
        $iframeHandler->updatehits($frameid);
        $xoopsTpl->assign('frameok', true);
        $xoopsTpl->assign('longdesc', $frame->getVar('frame_description'));
        $xoopsTpl->assign('width', $frame->getVar('frame_width'));
        $xoopsTpl->assign('height', $frame->getVar('frame_height'));
        $xoopsTpl->assign('align', $tblalign[(string)($frame->getVar('frame_align') - 1)]);
        $xoopsTpl->assign('frameborder', $frame->getVar('frame_frameborder'));
        $xoopsTpl->assign('marginwidth', $frame->getVar('frame_marginwidth'));
        $xoopsTpl->assign('marginheight', $frame->getVar('frame_marginheight'));
        $xoopsTpl->assign('scrolling', $tblscrolling[(string)($frame->getVar('frame_scrolling') - 1)]);
        if ('' !== xoops_trim($suplparam)) {
            $xoopsTpl->assign('url', $frame->getVar('frame_url') . '?' . $suplparam);
        } else {
            $xoopsTpl->assign('url', $frame->getVar('frame_url'));
        }
        $title = $frame->getVar('frame_description');
        myiframe_set_metas($title, $title);
    } else {
        $xoopsTpl->assign('frameok', false);
        $xoopsTpl->assign('frame_error', _MYIFRAME_FRAME_ERROR);
    }
} else {
    if (myiframe_getmoduleoption('showlist')) {
        $baseurl = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php';
        $frarray = [];
        $critere = new \Criteria('1', '1', '=');
        $critere->setSort('frame_description');
        $frarray = $iframeHandler->getObjects($critere);
        if (count($frarray) > 0) {
            foreach ($frarray as $frame) {
                /** @var Myiframe $frame */
                if ('' === xoops_trim($frame->getVar('frame_description'))) {
                    $liendesc = $frame->getVar('frame_url');
                } else {
                    $liendesc = "<a href='" . $baseurl . '?iframeid=' . $frame->getVar('frame_frameid') . "'>" . $frame->getVar('frame_description') . '</a>';
                }
                $iframe['list'] = $liendesc;
                $xoopsTpl->append('iframes', $iframe);
            }
        }
    } else {
        $xoopsTpl->assign('frameok', false);
        $xoopsTpl->assign('frame_error', _MYIFRAME_FRAME_ERROR);
    }
}
require_once XOOPS_ROOT_PATH . '/footer.php';
