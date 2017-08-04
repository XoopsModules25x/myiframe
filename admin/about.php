<?php
#######################################################
#  Visites de Membres version 2.1 pour Xoops 2.0.x	#
#  Copyright © 2002, Pascal Le Boustouller		#
#  Adaptation © 2003, Solo ( www.wolfpackclan.com )	#
#  Visites de Membres version 2.5 pour Xoops 2.5.8+	#
#  Adaptation © 2017 XOOPS 2.5.8+ (PHP7) - Aerograf
#  									#
#  Licence : GPL 							#
#######################################################

require_once 'admin_header.php';
xoops_cp_header();
$adminObject  = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));
\Xmf\Module\Admin::setPaypal('aerograf@shmel.org');
$adminObject->displayAbout(false);

require_once 'admin_footer.php';
