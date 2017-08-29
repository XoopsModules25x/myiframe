<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

require_once __DIR__ . '/../../mainfile.php';
require_once XOOPS_ROOT_PATH . '/modules/myiframe/include/functions.php';
$GLOBALS['xoopsOption']['template_main'] = 'myiframe.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

$suplparam = '';
if (isset($_GET)) {
    foreach ($_GET as $k => $v) {
        if (strtoupper(trim($k)) !== 'IFRAMEID') {
            $suplparam .= $k . '=' . $v . '&';
        }
    }
}

if (strlen(xoops_trim($suplparam)) > 0) {
    $suplparam = substr($suplparam, 0, strlen($suplparam) - 1);
}

$iframeHandler = xoops_getModuleHandler('myiframe', 'myiframe');

if (isset($_GET['iframeid'])) {
    $tblalign     = [
        'top',
        'middle',
        'bottom',
        'left',
        'rigth'
    ];
    $tblscrolling = [
        'yes',
        'no',
        'auto'
    ];
    $frameid      = (int)$_GET['iframeid'];

    $frame = $iframeHandler->get($frameid);

    if (is_object($frame)) {
        $iframeHandler->updatehits($frameid);
        $xoopsTpl->assign('frameok', true);
        $xoopsTpl->assign('longdesc', $frame->getVar('frame_description'));
        $xoopsTpl->assign('width', $frame->getVar('frame_width'));
        $xoopsTpl->assign('height', $frame->getVar('frame_height'));
        $xoopsTpl->assign('align', $tblalign[$frame->getVar('frame_align') - 1]);
        $xoopsTpl->assign('frameborder', $frame->getVar('frame_frameborder'));
        $xoopsTpl->assign('marginwidth', $frame->getVar('frame_marginwidth'));
        $xoopsTpl->assign('marginheight', $frame->getVar('frame_marginheight'));
        $xoopsTpl->assign('scrolling', $tblscrolling[$frame->getVar('frame_scrolling') - 1]);
        if (xoops_trim($suplparam) !== '') {
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
        $critere = new Criteria('1', '1', '=');
        $critere->setSort('frame_description');
        $frarray = $iframeHandler->getObjects($critere);
        if (count($frarray) > 0) {
            foreach ($frarray as $frame) {
                if (xoops_trim($frame->getVar('frame_description') === '')) {
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
include XOOPS_ROOT_PATH . '/footer.php';
