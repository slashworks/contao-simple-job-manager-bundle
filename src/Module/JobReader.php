<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\Module;

use Contao\Controller;
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
        Controller::loadLanguageFile('tl_sjm_jobs');

        $aOptions = array
        (
            'alias' => \Input::get('job')
        );

        $oJob = \Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs::findOneBy( 'alias', $aOptions['alias'] );
        $oParentOrganisation = \Slashworks\ContaoSimpleJobManagerBundle\Models\Organisation::findOneBy('id' , $oJob->pid);
        //Manipulating Organistaion Data:
        $oParentOrganisation->logo = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oParentOrganisation->logo)->path;
        //Manipulating Job Data:
        $oJob->dateposted = Date::parse('d.m.Y', $oJob->dateposted);
        $oJob->validthrough = Date::parse('d.m.Y', $oJob->validthrough);
        $oJob->startingfrom = Date::parse('d.m.Y', $oJob->startingfrom);
        $oJob->Gdateposted = Date::parse('Y-m-d', $oJob->dateposted);
        $oJob->Gvalidthrough = Date::parse('Y-m-d', $oJob->validthrough);
        $oJob->Gstartingfrom = Date::parse('Y-m-d', $oJob->startingfrom);
        $oJob->pdf = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oJob->pdf)->path;
        $oJob->image = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oJob->image)->path;

        $this->Template->organisation = $oParentOrganisation;
        $this->Template->job = $oJob;

        return;

    }
}
