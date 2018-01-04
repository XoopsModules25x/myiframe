<?php
/**
 * ****************************************************************************
 * MYIFRAME - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * ****************************************************************************
 */

// Nom du module
define('_MI_MYIFRAME_NAME', 'iFrames');

// Description du module
define('_MI_MYIFRAME_DESC', 'You can manage as many iframe pages as you want');

// Pour le menu d'admin
define('_MI_MYIFRAME_ADMENU1', 'Manage iFrames');
define('_MI_MYIFRAME_ADMENU2', 'About');
// New in version 1.4 *******************************************************************************************
define('_MI_MYIFRAME_OPT0', 'Display iframes in the Xoops menu ?');
define('_MI_MYIFRAME_OPT0_DSC', 'With this option, you can have links towards your iframes in the Xoops menu');

define('_MI_MYIFRAME_OPT1', 'Displays iframes list ?');
define('_MI_MYIFRAME_OPT1_DSC', "when the module's index page is called without parameters,<br> the page displays a list of the available iframes");

define('_MI_MYIFRAME_BNAME1', 'Show an iframe');

//Help
define('_MI_MYIFRAME_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_MYIFRAME_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_MYIFRAME_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_MYIFRAME_OVERVIEW', 'Overview');

//help multi-page
define('_MI_MYIFRAME_DISCLAIMER', 'Disclaimer');
define('_MI_MYIFRAME_LICENSE', 'License');
define('_MI_MYIFRAME_SUPPORT', 'Support');
