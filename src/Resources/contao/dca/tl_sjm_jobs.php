<?php

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_DCA']['tl_sjm_jobs'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_sjm_organisation',
        'switchToEdit'                => true,
        'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'pid' => 'index'
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 4,
            'fields'                  => array('title'),
            'headerFields'            => array('title', 'jumpTo', 'tstamp', 'protected', 'allowComments'),
            'panelLayout'             => 'filter;sort,search,limit',
            'child_record_callback'   => array('tl_sjm_jobs', 'listJobs'),
            'child_record_class'      => 'no_padding'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg'
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['editmeta'],
                'href'                => 'act=edit',
                'icon'                => 'header.svg'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['copy'],
                'href'                => 'act=paste&amp;mode=copy',
                'icon'                => 'copy.svg'
            ),
            'cut' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['cut'],
                'href'                => 'act=paste&amp;mode=cut',
                'icon'                => 'cut.svg'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['toggle'],
                'icon'                => 'visible.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback'     => array('tl_sjm_jobs', 'toggleIcon')
            ),
            'feature' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['feature'],
                'icon'                => 'featured.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleFeatured(this,%s)"',
                'button_callback'     => array('tl_sjm_jobs', 'iconFeatured')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array('addImage', 'addEnclosure', 'source', 'overwriteMeta'),
        'default'                     => '{title_legend},title,business,alias,description,responsibilities,skills,qualifications,educationRequirements,experienceRequirements,jobnumber,employmenttype;{date_legend},dateposted,validthrough,startingfrom,workingtimes,jobexpiration;{address_legend},addressstreet,addresslocality,addressregion,addresspostalcode,addresscountry;{contact_legend},contactname,contactemail,contactaddressphone,contactaddressstreet,contactaddresspostalcode,contactaddresslocality;{document_legend},image,pdf;'
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'foreignKey'              => 'tl_sjm_organistation.title',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['title'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'business'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['business'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'alias' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['alias'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'alias', 'doNotCopy'=>true, 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50 clr'),
            'save_callback' => array
            (
                array('tl_sjm_jobs', 'generateAlias')
            ),
            'sql'                     => "varchar(255) COLLATE utf8_bin NOT NULL default ''"
        ),
        'description' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['description'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'responsibilities' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['responsibilities'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'skills' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['skills'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'qualifications' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['qualifications'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'educationRequirements' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['educationRequirements'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'experienceRequirements' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['experienceRequirements'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
            'sql'                     => "text NULL"
        ),
        'jobnumber' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['jobnumber'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'dateposted' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['dateposted'],
            'default'                 => time(),
            'exclude'                 => true,
            'filter'                  => true,
            'sorting'                 => true,
            'flag'                    => 8,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'load_callback' => array
            (
                array('tl_sjm_jobs', 'loadDate')
            ),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'validthrough' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['validthrough'],
            'default'                 => time(),
            'exclude'                 => true,
            'filter'                  => true,
            'sorting'                 => true,
            'flag'                    => 8,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'load_callback' => array
            (
                array('tl_sjm_jobs', 'loadDate')
            ),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'startingfrom' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['startingfrom'],
            'default'                 => time(),
            'exclude'                 => true,
            'filter'                  => true,
            'sorting'                 => true,
            'flag'                    => 8,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
            'load_callback' => array
            (
                array('tl_sjm_jobs', 'loadDate')
            ),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'employmenttype'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['employmenttype'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'select',
            'options'   => array('FULL_TIME','PART_TIME','CONTRACTOR','TEMPORARY','INTERN','VOLUNTEER','PER_DIEM','OTHER'),
            'reference' => &$GLOBALS['TL_LANG']['tl_sjm_jobs'],
            'eval'      => array('mandatory'=>true, 'maxlength'=>64, 'tl_class'=>'w50 wizard'),
            'sql'       => "varchar(64) NOT NULL default ''",
        ),
        'addressstreet' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['addressstreet'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'addresslocality' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['addresslocality'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'addressregion' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['addressregion'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'addresspostalcode' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['addresspostalcode'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'addresscountry' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['addresscountry'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'workhours' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['workhours'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'jobexpiration' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['jobexpiration'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'image'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['image'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => array('filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'clr'),
            'sql'       => "binary(16) NULL",
        ),
        'pdf'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['pdf'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => array('filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'clr'),
            'sql'       => "binary(16) NULL",
        ),
        'contactname' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['contactname'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'contactemail' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['contactemail'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'contactaddressstreet' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['contactaddressstreet'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'contactaddresspostalcode' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['contactaddresspostalcode'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'contactaddresslocality' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['contactaddresslocality'],
            'exclude'                 => true,
            'search'                  => true,
            'sorting'                 => true,
            'flag'                    => 1,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'contactaddressphone' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_sjm_jobs']['contactaddressphone'],
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

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @property Contao\News $News
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_sjm_jobs extends Backend
{
    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Set the timestamp to 00:00:00 (see #26)
     *
     * @param integer $value
     *
     * @return integer
     */
    public function loadDate($value)
    {
        return strtotime(date('Y-m-d', $value) . ' 00:00:00');
    }

    /**
     * List a news article
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function listJobs($arrRow)
    {
        return '<div class="tl_content_left">' . $arrRow['title'] . ' <span style="color:#999;padding-left:3px">[' . Date::parse(Config::get('datimFormat'), $arrRow['dateposted']) . ']</span></div>';
    }

    /**
     * Return the "feature/unfeature element" button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function iconFeatured($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('fid')))
        {
            $this->toggleFeatured(Input::get('fid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;fid=' . $row['id'] . '&amp;state=' . ($row['featured'] ? '' : 1);

        if (!$row['featured'])
        {
            $icon = 'featured_.svg';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label, 'data-state="' . ($row['featured'] ? 1 : 0) . '"') . '</a> ';
    }

    /**
     * Feature/unfeature a news item
     *
     * @param integer       $intId
     * @param boolean       $blnVisible
     * @param DataContainer $dc
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function toggleFeatured($intId, $blnVisible, DataContainer $dc=null)
    {
        // Check permissions to edit
        Input::setGet('id', $intId);
        Input::setGet('act', 'feature');
        $this->checkPermission();

        $objVersions = new Versions('tl_sjm_jobs', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_sjm_jobs']['fields']['featured']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_sjm_jobs']['fields']['featured']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, $this);
                }
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_sjm_jobs SET tstamp=" . time() . ", featured='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
                       ->execute($intId);

        $objVersions->create();
    }

    /**
     * Return the "toggle visibility" button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.svg';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
    }

    /**
     * Disable/enable a user group
     *
     * @param integer       $intId
     * @param boolean       $blnVisible
     * @param DataContainer $dc
     */
    public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
    {
        // Set the ID and action
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        if ($dc)
        {
            $dc->id = $intId; // see #8043
        }

        // Trigger the onload_callback
        if (is_array($GLOBALS['TL_DCA']['tl_sjm_jobs']['config']['onload_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_sjm_jobs']['config']['onload_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }

        // Set the current record
        if ($dc)
        {
            $objRow = $this->Database->prepare("SELECT * FROM tl_sjm_jobs WHERE id=?")
                                     ->limit(1)
                                     ->execute($intId);

            if ($objRow->numRows)
            {
                $dc->activeRecord = $objRow;
            }
        }

        $objVersions = new Versions('tl_sjm_jobs', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_sjm_jobs']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_sjm_jobs']['fields']['published']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, $dc);
                }
            }
        }

        $time = time();

        // Update the database
        $this->Database->prepare("UPDATE tl_sjm_jobs SET tstamp=$time, published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
                       ->execute($intId);

        if ($dc)
        {
            $dc->activeRecord->tstamp = $time;
            $dc->activeRecord->published = ($blnVisible ? '1' : '');
        }

        // Trigger the onsubmit_callback
        if (is_array($GLOBALS['TL_DCA']['tl_sjm_jobs']['config']['onsubmit_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_sjm_jobs']['config']['onsubmit_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }

        $objVersions->create();
    }

    /**
     * Auto-generate the news alias if it has not been set yet
     *
     * @param mixed         $varValue
     * @param DataContainer $dc
     *
     * @return string
     *
     * @throws Exception
     */
    public function generateAlias($varValue, DataContainer $dc)
    {
        $autoAlias = false;

        // Generate alias if there is none
        if ($varValue == '')
        {
            $autoAlias = true;
            $varValue = StringUtil::generateAlias($dc->activeRecord->title);
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_sjm_jobs WHERE alias=? AND id!=?")
                                   ->execute($varValue, $dc->id);

        // Check whether the news alias exists
        if ($objAlias->numRows)
        {
            if (!$autoAlias)
            {
                throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
            }

            $varValue .= '-' . $dc->id;
        }

        return $varValue;
    }
}
