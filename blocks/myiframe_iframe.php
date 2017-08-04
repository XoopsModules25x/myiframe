<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

include_once XOOPS_ROOT_PATH . '/modules/myiframe/include/functions.php';

function b_myiframe_iframe_show($options)
{
    $block          = array();
    $tblalign       = array(
        'top',
        'middle',
        'bottom',
        'left',
        'rigth'
    );
    $tblscrolling   = array(
        'yes',
        'no',
        'auto'
    );
    $iframeHandler = xoops_getModuleHandler('myiframe', 'myiframe');
    $frame          = null;
    $frame          = $iframeHandler->get($options[0]);

    if (is_object($frame)) {
        $block['longdesc']     = $frame->getVar('frame_description');
        $block['width']        = $frame->getVar('frame_width');
        $block['height']       = $frame->getVar('frame_height');
        $block['align']        = $tblalign[$frame->getVar('frame_align') - 1];
        $block['frameborder']  = $frame->getVar('frame_frameborder');
        $block['marginwidth']  = $frame->getVar('frame_marginwidth');
        $block['marginheight'] = $frame->getVar('frame_marginheight');
        $block['scrolling']    = $tblscrolling[$frame->getVar('frame_scrolling') - 1];
        $block['url']          = $frame->getVar('frame_url');
    }
    return $block;
}

function b_myiframe_iframe_edit($options)
{
    $iframeHandler = xoops_getModuleHandler('myiframe', 'myiframe');
    $frarray        = array();
    $critere        = new Criteria('1', '1', '=');
    $critere->setSort('frame_description');
    $frarray = $iframeHandler->getObjects($critere);

    $form = '' . _MB_MYIFRAME_IFRAME . "&nbsp;<select name='options[0]'>";
    foreach ($frarray as $oneframe) {
        $form .= "<option value='" . $oneframe->getVar('frame_frameid') . "'";
        if ($options[0] == $oneframe->getVar('frame_frameid')) {
            $form .= " selected='selected'";
        }
        $form .= '>' . $oneframe->getVar('frame_description') . '</option>';
    }
    $form .= "</select>\n";
    return $form;
}

function b_myiframe_iframe_onthefly($options)
{
    $options = explode('|', $options);
    $block   = &b_myiframe_iframe_show($options);

    $tpl = new XoopsTpl();
    $tpl->assign('block', $block);
    $tpl->display('db:myiframe_block_show.tpl');
}
