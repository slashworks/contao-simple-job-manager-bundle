<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\Module;

use Contao\Date;
use Contao\FilesModel;
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

        $oJob = \Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs::findOneBy( 'alias', $aOptions['alias'] );
        $oParentOrganisation = \Slashworks\ContaoSimpleJobManagerBundle\Models\Organisation::findOneBy('id' , $oJob->pid);
        //Manipulating Organistaion Data:
        $oParentOrganisation->logo = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oParentOrganisation->logo)->path;
        //Manipulating Job Data:
        $oJob->dateposted = Date::parse('Y-m-d', $oJob->dateposted);
        $oJob->validthrough = Date::parse('Y-m-d', $oJob->validthrough);
        $oJob->startingfrom = Date::parse('Y-m-d', $oJob->startingfrom);
        $oJob->pdf = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oJob->pdf)->path;
        $oJob->image = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oJob->image)->path;

        $this->Template->organisation = $oParentOrganisation;
        $this->Template->job = $oJob;

        return;

    }
}
