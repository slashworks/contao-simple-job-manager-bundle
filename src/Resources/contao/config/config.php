<?php

use Slashworks\ContaoSimpleJobManagerBundle\EventListener\GetSearchablePagesListener;

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['sjm'] = array
(
    'organisation'   => array
    (
        'tables' => array('tl_sjm_organisation', 'tl_sjm_jobs'),
    )
);

/**
 * Backend Styles
 */
if (TL_MODE === 'BE') {
    // Add custom CSS for ProductList module.
    $GLOBALS['TL_CSS'][] = 'bundles/contaosimplejobmanager/backend.css';
}
/**
 * Register models
 */
$GLOBALS['TL_MODELS']['tl_sjm_organisation'] = 'Slashworks\ContaoSimpleJobManagerBundle\Models\Organisation';
$GLOBALS['TL_MODELS']['tl_sjm_jobs'] = 'Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs';
/**
 * Register Modules
 */
$GLOBALS['FE_MOD']['sjm']['job-list'] = 'Slashworks\ContaoSimpleJobManagerBundle\Module\JobList';
$GLOBALS['FE_MOD']['sjm']['job-reader'] = 'Slashworks\ContaoSimpleJobManagerBundle\Module\JobReader';


$GLOBALS['sjm']['jobsorting']['options'] = array('dateposted','validthrough','title','jobnumber','business');

/**
 * Register Hooks
 */
$GLOBALS['TL_HOOKS']['getSearchablePages'][] = [GetSearchablePagesListener::class, '__invoke'];
