How to create an iframe "on the fly".
In the Xoops blocks manager, create a new personalized Php block and type this :

include_once XOOPS_ROOT_PATH . '/modules/myiframe/blocks/myiframe_iframe.php';
b_myiframe_iframe_onthefly(1);


Replace 1 (in the expression b_myiframe_iframe_onthefly(1);) with the iframe ID you
want to display.
--------------------------------------------------------------------------------------------

Comment créer des blocs à la volée.
Dans le gestionnaire de blocs de Xoops, créez un bloc personnalisé au format Php dont
le contenu est le suivant :

include_once XOOPS_ROOT_PATH . '/modules/myiframe/blocks/myiframe_iframe.php';
b_myiframe_iframe_onthefly(1);

Remplacez 1 (dans l'expression b_myiframe_iframe_onthefly(1);) par l'identifiant
de l'iframe que vous souhaitez afficher.