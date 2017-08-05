<?php
/**
 * Printliminator module
 *
 * @copyright           The XOOPS Project https://github.com/XoopsModules25x
 * @license             http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package             Printliminator
 * @since               0.1.0
 * @author              aerograf <https://www.shmel.org>
 * @version             $Id: blocks_mytype.php 2017-06-06
 **/

include_once __DIR__ . '/admin_header.php';
xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayIndex();

include_once __DIR__ . '/admin_footer.php';
