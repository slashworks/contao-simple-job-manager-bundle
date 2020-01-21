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
class JobReader extends Module
{

    /**
     * @var string
     */
    protected $strTemplate = 'mod_jobreader';

    /**
     * @return string
     */
    public function generate()
    {
        if ( TL_MODE == 'BE' ) {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate( 'be_wildcard' );

            $objTemplate->wildcard = '### Jobleser ###';

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
            'alias' => \Input::get('job')
        );

        $oJob = \Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs::findOneBy( $aOptions );

        return $this->Template->job = $oJob;

    }
}
