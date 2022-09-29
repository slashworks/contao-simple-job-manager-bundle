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
        'ctable'            => array('tl_sjm_jobs'),
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
            'fields' => array('title', 'organisation'),
            'format'  => '%s - %s',
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
                'href'  => 'table=tl_sjm_jobs',
                'icon'  => 'edit.svg',
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_news_archive']['editheader'],
                'href'                => 'act=edit',
                'icon'                => 'header.svg',
                'button_callback'     => array('tl_sjm_organisation', 'editHeader')
            ),
            'delete' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null ) . '\'))return false;Backend.getScrollOffset()"',
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
        'default' => '{title_legend},title,organisation,url,logo;{address_legend},addressstreet,addresslocality,addressregion,addresspostalcode,addresscountry',
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
        'sorting' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
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
        'addressstreet' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['addressstreet'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'addresslocality' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['addresslocality'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'addressregion' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['addressregion'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'addresspostalcode' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['addresspostalcode'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'addresscountry' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_organisation']['addresscountry'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
    )
);

class tl_sjm_organisation extends Backend
{
    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    public function editHeader($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->canEditFieldsOf('tl_sjm_organisation') ? '<a href="' . $this->addToUrl($href . '&amp;id=' . $row['id']) . '" title="' . StringUtil::specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label) . '</a> ' : Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)) . ' ';
    }
}
