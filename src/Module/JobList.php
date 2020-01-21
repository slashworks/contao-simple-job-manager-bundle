<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\Module;

use Contao\Input;
use Contao\Module;

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

        $oJobs = \Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs::findAll( $aOptions );

        return $this->Template->jobs = $oJobs;

    }
}
