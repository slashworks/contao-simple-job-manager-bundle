<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\Module;

use Contao\Controller;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\FilesModel;
use Contao\Image\PictureConfiguration;
use Contao\Input;
use Contao\Module;
use Contao\PageModel;

/**
 * Content element that lists Organisations to jump to Jobs.
 *
 * Class OrganisationList
 *
 * @package Slashworks\ContaoSimpleJobManagerBundle\Elements
 */
class JobList extends Module
{

    /**
     * @var string
     */
    protected $strTemplate = 'mod_joblist';

    /**
     * @return string
     */
    public function generate()
    {
        if ( TL_MODE == 'BE' ) {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate( 'be_wildcard' );
            $objTemplate->wildcard = '### Jobliste ###';

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the content element.
     */
    protected function compile()
    {

        $aOptions = array
        (
            'order'  => $this->jobsorting . ' ' . $this->sortorder,

        );

        $aJobsByOrganisation = array();
        $oOrganisations = \Slashworks\ContaoSimpleJobManagerBundle\Models\Organisation::findAll();

        foreach($oOrganisations as $oOrganisation) {

            $aJobsByOrganisation[$oOrganisation->id]['id'] = $oOrganisation->id;
            $aJobsByOrganisation[$oOrganisation->id]['title'] = $oOrganisation->title;
            $aJobsByOrganisation[$oOrganisation->id]['organisation'] = $oOrganisation->organisation;
            $oJobs = \Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs::findBy( 'pid',  $oOrganisation->id);
            $sOrganizationLogo = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oOrganisation->logo)->path;
            $oPage = PageModel::findBy('id', $this->jumpTo);
            $aJobsByOrganisation[$oOrganisation->id]['organisationLogoUrl'] = $sOrganizationLogo;

            foreach($oJobs as $oJob) {

                $sPageJumpTo = Controller::generateFrontendUrl($oPage->row(), '/job/' . $oJob->alias);

                $aJobsByOrganisation[$oOrganisation->id]['jobs'][] = array
                (
                    'id' => $oJob->id,
                    'jobTitle' => $oJob->title,
                    'jobJumpTo' => $sPageJumpTo,
                );

            }

        }

        $this->Template->jobs = $aJobsByOrganisation;

        return;

    }
}
