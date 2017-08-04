<?php

$pathIcon32 = \Xmf\Module\Admin::iconUrl('', 32);
echo "<br style='clear:both;' />";
echo "<div style='text-align:center;vertical-align:middle;'><div style='display:inline-block;float:right;' class='center smallsmall italic pad5'><a href='http://xoops.instant-zero.com' target='_blank'><img src='../assets/images/instantzero.gif'></a></div>";
echo "<div style='display:inline-block;' class='center smallsmall italic pad5'><strong>" . $xoopsModule->getVar("name")
     . "</strong> is maintained by the <br /><br /><a class='tooltip' rel='external' href='http://www.xoops.org/' title='Visit XOOPS Community'><img src='{$pathIcon32}/xoopsmicrobutton.gif' alt='XOOPS' title='XOOPS'></a></div></div>";
xoops_cp_footer();
