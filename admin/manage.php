<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

include __DIR__ . '/../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH . '/modules/myiframe/include/functions.php';

// Verify if the table is up to date
if (!myiframe_FieldExists('frame_frameid', $xoopsDB->prefix('myiframe'))) {
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . ' CHANGE `frameid` `frame_frameid` INT( 8 ) NOT NULL AUTO_INCREMENT');
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . " CHANGE `created` `frame_created` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0'");
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . " CHANGE `uid` `frame_uid` MEDIUMINT( 8 ) UNSIGNED NOT NULL DEFAULT '0'");
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . ' CHANGE `longdesc` `frame_description` VARCHAR( 255 ) NOT NULL');
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . ' CHANGE `width` `frame_width` VARCHAR( 15 ) NOT NULL');
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . ' CHANGE `height` `frame_height` VARCHAR( 15 ) NOT NULL');
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . " CHANGE `align` `frame_align` SMALLINT( 2 ) NOT NULL DEFAULT '0'");
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . " CHANGE `frameborder` `frame_frameborder` SMALLINT( 3 ) NOT NULL DEFAULT '0'");
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . " CHANGE `marginwidth` `frame_marginwidth` SMALLINT( 3 ) NOT NULL DEFAULT '0'");
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . " CHANGE `marginheight` `frame_marginheight` SMALLINT( 3 ) NOT NULL DEFAULT '0'");
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . " CHANGE `scrolling` `frame_scrolling` SMALLINT( 1 ) NOT NULL DEFAULT '0'");
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . " CHANGE `hits` `frame_hits` INT( 8 ) UNSIGNED NOT NULL DEFAULT '0'");
    $result = $xoopsDB->queryF('ALTER TABLE ' . $xoopsDB->prefix('myiframe') . ' CHANGE `url` `frame_url` VARCHAR( 255 ) NOT NULL');
    header('Location : ' . XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=myiframe');
}

$module_id     = $xoopsModule->getVar('mid');
$op            = 'default';
$iframeHandler = xoops_getModuleHandler('myiframe', 'myiframe');

/**
 * @param $frameid
 * @param $Action
 * @param $FormTitle
 * @param $longdesc
 * @param $width
 * @param $height
 * @param $align
 * @param $frameborder
 * @param $marginwidth
 * @param $marginheight
 * @param $scrolling
 * @param $url
 * @param $LabelSubmitButton
 */
function addEditForm($frameid, $Action, $FormTitle, $longdesc, $width, $height, $align, $frameborder, $marginwidth, $marginheight, $scrolling, $url, $LabelSubmitButton)
{
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    global $xoopsModule;

    $sform = new XoopsThemeForm($FormTitle, 'indexform', XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/manage.php');
    $sform->addElement(new XoopsFormText(_AM_MYIFRAME_DESC, 'longdesc', 50, 255, $longdesc), false);
    $sform->addElement(new XoopsFormText(_AM_MYIFRAME_WIDTH, 'width', 10, 15, $width), false);
    $sform->addElement(new XoopsFormText(_AM_MYIFRAME_HEIGHT, 'height', 10, 15, $height), false);

    $selalign = new XoopsFormSelect(_AM_MYIFRAME_ALIGN, 'align', $align);
    $selalign->addOption(1, _AM_MYIFRAME_ALIGN_TOP);
    $selalign->addOption(2, _AM_MYIFRAME_ALIGN_MIDDLE);
    $selalign->addOption(3, _AM_MYIFRAME_ALIGN_BOTTOM);
    $selalign->addOption(4, _AM_MYIFRAME_ALIGN_LEFT);
    $selalign->addOption(5, _AM_MYIFRAME_ALIGN_RIGHT);
    $selalign->setValue($align);
    $sform->addElement($selalign);

    $sform->addElement(new XoopsFormText(_AM_MYIFRAME_FRAMEBORDER, 'frameborder', 3, 3, $frameborder), false);
    $sform->addElement(new XoopsFormText(_AM_MYIFRAME_MARGINWIDTH, 'marginwidth', 3, 3, $marginwidth), false);
    $sform->addElement(new XoopsFormText(_AM_MYIFRAME_MARGINHEIGHT, 'marginheight', 3, 3, $marginheight), false);

    $selscroll = new XoopsFormSelect(_AM_MYIFRAME_SCROLLING, 'scrolling', $scrolling);
    $selscroll->addOption(1, _YES);
    $selscroll->addOption(2, _NO);
    $selscroll->addOption(3, _AM_MYIFRAME_AUTO);
    $selscroll->setValue($scrolling);
    $sform->addElement($selscroll);

    $sform->addElement(new XoopsFormText(_AM_MYIFRAME_URL, 'url', 50, 255, $url), true);
    $sform->addElement(new XoopsFormHidden('op', $Action), false);
    if (!empty($frameid)) {
        $sform->addElement(new XoopsFormHidden('frameid', $frameid), false);
    }

    $button_tray = new XoopsFormElementTray('', '');
    $submit_btn  = new XoopsFormButton('', 'submit', $LabelSubmitButton, 'submit');
    $button_tray->addElement($submit_btn);
    $cancel_btn = new XoopsFormButton('', 'reset', _AM_MYIFRAME_RESETBUTTON, 'reset');
    $button_tray->addElement($cancel_btn);
    $sform->addElement($button_tray);
    $sform->display();
    include_once __DIR__ . '/admin_footer.php';
}

// ******************************************************************************************************************************************
// **** Main ********************************************************************************************************************************
// ******************************************************************************************************************************************

if (isset($_POST['op'])) {
    $op = $_POST['op'];
} elseif (isset($_GET['op'])) {
    $op = $_GET['op'];
}

switch ($op) {
    case 'verifybeforeedit':
        if (isset($_POST['submit']) && $_POST['submit'] !== '') {
            if ($_POST['longdesc'] === '') {
                xoops_cp_header();
                $adminObject = \Xmf\Module\Admin::getInstance();
                $adminObject->displayNavigation(basename(__FILE__));
                echo "<table width='100%' border='0' cellspacing='1' class='outer'>\n";
                echo '<tr><td class="odd">';
                echo "<a href='manage.php'><h4>" . _AM_MYIFRAME_CONFIG . '</h4></a>';
                echo _AM_MYIFRAME_ERROR_ADD_INDEX;
                echo '</td></tr></table>';
                include_once __DIR__ . '/admin_footer.php';
                xoops_cp_footer();
                exit();
            }

            $frameid = $_POST['frameid'];
            $frame   = $iframeHandler->get($frameid);
            $frame->unsetNew();
            $frame->setVar('frame_description', $_POST['longdesc']);
            $frame->setVar('frame_width', $_POST['width']);
            $frame->setVar('frame_height', $_POST['height']);
            $frame->setVar('frame_align', $_POST['align']);
            $frame->setVar('frame_frameborder', $_POST['frameborder']);
            $frame->setVar('frame_marginwidth', $_POST['marginwidth']);
            $frame->setVar('frame_marginheight', $_POST['marginheight']);
            $frame->setVar('frame_scrolling', $_POST['scrolling']);
            $frame->setVar('frame_url', $_POST['url']);
            $frame->setVar('frame_uid', $xoopsUser->getVar('uid'));
            $res = $iframeHandler->insert($frame);
            if (!$res) {
                redirect_header('manage.php', 1, _AM_MYIFRAME_ERROR_MODIFY_DB);
            }
            redirect_header('manage.php', 1, _AM_MYIFRAME_DBUPDATED);
        }
        break;

    case 'edit':
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        if (isset($_GET['frameid'])) {
            $frameid = (int)$_GET['frameid'];
            $frame   = $iframeHandler->get($frameid);
            addEditForm($frameid, 'verifybeforeedit', _AM_MYIFRAME_CONFIG, $frame->getVar('frame_description', 'e'), $frame->getVar('frame_width', 'e'), $frame->getVar('frame_height', 'e'), $frame->getVar('frame_align', 'e'),
                        $frame->getVar('frame_frameborder', 'e'), $frame->getVar('frame_marginwidth', 'e'), $frame->getVar('frame_marginheight', 'e'), $frame->getVar('frame_scrolling', 'e'), $frame->getVar('frame_url', 'e'), _AM_MYIFRAME_UPDATE);
        } else {
            xoops_cp_header();
            $adminObject = \Xmf\Module\Admin::getInstance();
            $adminObject->displayNavigation(basename(__FILE__));
            echo "<table width='100%' border='0' cellspacing='1' class='outer'>\n";
            echo '<tr><td class="odd">';
            echo "<a href='manage.php'><h4>" . _AM_MYIFRAME_CONFIG . '</h4></a>';
            echo _AM_MYIFRAME_ERROR_ADD_INDEX;
            echo "</td></tr></table>\n";
            include_once __DIR__ . '/admin_footer.php';
            xoops_cp_footer();
            exit();
        }
        break;

    case 'delete':
        if (!isset($_POST['ok'])) {
            xoops_cp_header();
            $adminObject = \Xmf\Module\Admin::getInstance();
            $adminObject->displayNavigation(basename(__FILE__));
            echo '<h4>' . _AM_MYIFRAME_CONFIG . '</h4>';
            xoops_confirm(array(
                              'op'      => 'delete',
                              'frameid' => (int)$_GET['frameid'],
                              'ok'      => 1
                          ), 'manage.php', _AM_MYIFRAME_RUSUREDEL);
            include_once __DIR__ . '/admin_footer.php';
        } else {
            if (empty($_POST['frameid'])) {
                redirect_header('manage.php', 2, _AM_MYIFRAME_ERROR_ADD_INDEX);
            }
            $frameid = (int)$_POST['frameid'];
            $critere = new Criteria('frame_frameid', $frameid, '=');
            $iframeHandler->deleteAll($critere);
            redirect_header('manage.php', 1, _AM_MYIFRAME_DBUPDATED);
        }
        break;

    case 'verifytoadd':
        if (isset($_POST['submit']) && $_POST['submit'] !== '') {
            if ($_POST['url'] === '') {
                xoops_cp_header();
                $adminObject = \Xmf\Module\Admin::getInstance();
                $adminObject->displayNavigation(basename(__FILE__));
                echo "<table width='100%' border='0' cellspacing='1' class='outer'>\n";
                echo '<tr><td class="odd">';
                echo "<a href='manage.php'><h4>" . _AM_MYIFRAME_CONFIG . '</h4></a>';
                echo _AM_MYIFRAME_ERROR_ADD_INDEX;
                echo "</td></tr></table>\n";
                include_once __DIR__ . '/admin_footer.php';
                xoops_cp_footer();
                $adminObject = \Xmf\Module\Admin::getInstance();
                $adminObject->displayNavigation(basename(__FILE__));
                exit();
            }
            $frame = $iframeHandler->create(true);
            $frame->setVar('frame_description', $_POST['longdesc']);
            $frame->setVar('frame_width', $_POST['width']);
            $frame->setVar('frame_height', $_POST['height']);
            $frame->setVar('frame_align', $_POST['align']);
            $frame->setVar('frame_frameborder', $_POST['frameborder']);
            $frame->setVar('frame_marginwidth', $_POST['marginwidth']);
            $frame->setVar('frame_marginheight', $_POST['marginheight']);
            $frame->setVar('frame_scrolling', $_POST['scrolling']);
            $frame->setVar('frame_url', $_POST['url']);
            $frame->setVar('frame_created', time());
            $frame->setVar('frame_uid', $xoopsUser->getVar('uid'));
            $res = $iframeHandler->insert($frame);
            if (!$res) {
                redirect_header('manage.php', 1, _AM_MYIFRAME_ERROR_ADD_INDEX);
            }
            redirect_header('manage.php', 1, _AM_MYIFRAME_ADDED_OK);
        }
        break;

    case 'addframe':
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        addEditForm(0, 'verifytoadd', _AM_MYIFRAME_CONFIG, '', '100%', '', '', '0', '0', '0', 1, '', _AM_MYIFRAME_ADDBUTTON);
        break;

    case 'default':
    default:
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        echo '<h4>' . _AM_MYIFRAME_CONFIG . "</h4><br />\n";
        echo "<table width='100%' border='0' cellspacing='1' class='outer'>\n";
        echo "<tr><th align='center'>" . _AM_MYIFRAME_ID . "</th><th align='center'>" . _AM_MYIFRAME_DESC . "</th><th align='center'>" . _AM_MYIFRAME_CREATED . "</th><th align='center'>" . _AM_MYIFRAME_HITS . "</th><th align='center'>"
             . _AM_MYIFRAME_ACTION . "</th></tr>\n";
        $critere = new Criteria('1', '1', '=');
        $critere->setSort('frame_description');
        $frarray = $iframeHandler->getObjects($critere);
        $class   = 'even';
        $baseurl = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/manage.php';
        if (count($frarray) > 0) {
            foreach ($frarray as $frame) {
                $action_edit   = "<a href='" . $baseurl . '?op=edit&frameid=' . $frame->getVar('frame_frameid') . "'><img src='../assets/images/edit.png' alt='" . _AM_MYIFRAME_EDIT . "'></a>";
                $action_delete = "<a href='" . $baseurl . '?op=delete&frameid=' . $frame->getVar('frame_frameid') . "'><img src='../assets/images/delete.png' alt='" . _AM_MYIFRAME_DELETE . "'></a>";
                if (xoops_trim($frame->getVar('frame_description') === '')) {
                    $liendesc = $frame->getVar('frame_url');
                } else {
                    $liendesc = "<a href='" . XOOPS_URL . '/modules/myiframe/index.php?iframeid=' . $frame->getVar('frame_frameid') . "'>" . $frame->getVar('frame_description') . '</a>';
                }
                echo "<tr class='" . $class . "'><td align='center'>" . $frame->getVar('frame_frameid') . "</td><td align='center'>" . $liendesc . "</td><td align='center'>" . formatTimestamp($frame->getVar('frame_created'))
                     . "</td><td align='center'>" . $frame->getVar('frame_hits') . "</td><td align='center'>" . $action_edit . '&nbsp;-&nbsp;' . $action_delete . "</td></tr>\n";
                $class = ($class === 'even') ? 'odd' : 'even';
            }
        }
        echo "<tr class='" . $class . "'><td colspan='5' align='center'><form name='faddframe' method='post' action='manage.php'><input type='hidden' name='op' value='addframe'><input type='submit' name='submit' value='" . _AM_MYIFRAME_ADD
             . "'></td></tr>";
        echo '</table>';
        include_once __DIR__ . '/admin_footer.php';
        break;
}

xoops_cp_footer();
