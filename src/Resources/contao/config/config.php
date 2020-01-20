<?php

// Frontend modules
$GLOBALS['FE_MOD']['miscellaneous']['simplejobmanager'] = 'Slashworks\ContaoSimpleJobManagerBundle\Module\SimpleJobManagerModule';

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['simplejobmanager'] = array
(
    'organisation'   => array
    (
        'tables' => array('tl_sjm_organisation'),
    ),
    'jobs' => array
    (
        'tables' => array('tl_sjm_jobs'),
    )
);

/**
 * Backend Styles
 */
if (TL_MODE === 'BE') {
    // Add custom CSS for ProductList module.
    $GLOBALS['TL_CSS'][] = 'bundles/slashworkssimplejobmanager/backend.css';
}
