<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Table tl_scm_company
 */
$GLOBALS['TL_DCA']['tl_sjm_organisation'] = array
(

    // Config
    'config'   => array
    (
        'dataContainer'     => 'Table',
        'enableVersioning'  => true,
        'sql'               => array
        (
            'keys' => array
            (
                'id' => 'primary',
            ),
        ),
    ),

    // List
    'list'     => array
    (
        'sorting'           => array
        (
            'mode'            => 1,
            'fields'          => array('title'),
            'flag'            => 11,
            'panelLayout'     => 'filter;search,limit',
            'disableGrouping' => true,
        ),
        'label'             => array
        (
            'fields' => array('title'),
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ),
        ),
        'operations'        => array
        (
            'edit'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg',
            ),
            'delete' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'show'   => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ),
        ),
    ),

    // Palettes
    'palettes' => array
    (
        'default' => '{title_legend},title,organisation,business,url,logo',
    ),

    // Fields
    'fields'   => array
    (
        'id'     => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ),
        'title'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['title'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'organisation'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['organisation'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'business'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['business'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'select',
            'options'   => array('','wert1','wert2','wert3','wert4','wert5'),
            'reference' => &$GLOBALS['TL_LANG']['tl_sjm_organisation'],
            'eval'      => array('mandatory'=>true, 'maxlength'=>64, 'tl_class'=>'w50 wizard')
        ),
        'url'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['url'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'logo'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['logo'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => array('filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'clr'),
            'sql'       => "binary(16) NULL",
        ),


    )
);
