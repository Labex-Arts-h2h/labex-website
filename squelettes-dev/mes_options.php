<?php 
// RECHERCHE (ne marche pas)
define('_SURLIGNE_RECHERCHE_REFERERS',true);

// CALCUL ZPIP
$GLOBALS['z_blocs']=array('contenu','navigation','extra','head');
define('_Z_AJAX_PARALLEL_LOAD','contenu,navigation');

//AUGMENTATION DU CACHE
$GLOBALS['quota_cache'] = 25;

?>