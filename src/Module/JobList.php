<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\Module;

use Contao\Controller;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\Date;
use Contao\FilesModel;
use Contao\Image\PictureConfiguration;
use Contao\Input;
use Contao\Module;
use Contao\PageModel;
use Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs;

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

        $bExpiredJobs = $this->expiredjob;
        $dTime = time();

        $aOptions = array
        (
            'order'  => 'pid, '.$this->jobsorting . ' ' . $this->sortorder,
        );

        if (!$bExpiredJobs) {
            $aOptions['column'][] = ' validthrough >= ' . $dTime;
        }

        $aJobsByOrganisation = array();
        $oOrganisations = \Slashworks\ContaoSimpleJobManagerBundle\Models\Organisation::findAll();

        $oJobs = Jobs::findAll($aOptions);


        /**
         * @var $oJob Jobs
         */
        foreach($oJobs as $oJob) {

                // generate URL
                $oPage = PageModel::findBy('id', $this->jumpTo);
                $oJob->jobJumpTo = Controller::generateFrontendUrl($oPage->row(), '/' . $oJob->alias);
                $oJob->organisation = $oJob->getRelated('pid');

            }

        $this->Template->jobs = $oJobs;

        return;

    }
}
