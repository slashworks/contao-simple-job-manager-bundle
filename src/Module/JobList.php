<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\Module;

use Contao\Controller;
use Contao\Module;
use Contao\PageModel;
use Contao\StringUtil;
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
            $aOptions['column'][] = 'validthrough >= ' . $dTime;
        }

        $organisations = StringUtil::deserialize($this->organisation, true);

        if (!empty($organisations)) {
            $aOptions['column'][] = 'pid IN(' . implode(',', array_map('intval', $organisations)) . ')';
        }

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
