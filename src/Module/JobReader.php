<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\Module;

use Contao\Controller;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\CoreBundle\Exception\RedirectResponseException;
use Contao\Date;
use Contao\FilesModel;
use Contao\Input;
use Contao\Module;
use Symfony\Component\VarDumper\VarDumper;

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

        // Redirect to new URL without /job
        if (!empty($GLOBALS['objPage']) && null !== Input::get('job')) {
            throw new RedirectResponseException($GLOBALS['objPage']->getAbsoluteUrl('/'.Input::get('job')));
        }

        $aOptions = array
        (
            'alias' => Input::get('auto_item')
        );

        $oJob = \Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs::findOneBy('alias', $aOptions['alias']);

        if ($oJob === null) {
            throw new PageNotFoundException('Page not found: ' . \Environment::get('uri'));
        }

        if ($oJob->validthrough < time()) {
            throw new PageNotFoundException('Page not found: ' . \Environment::get('uri'));
        }

        $oParentOrganisation = \Slashworks\ContaoSimpleJobManagerBundle\Models\Organisation::findOneBy('id' , $oJob->pid);
        if(null == $oJob){
            throw new PageNotFoundException('Page not found: ' . \Environment::get('uri'));
        }        
        //Manipulating Organistaion Data:
        $oParentOrganisation->logo = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oParentOrganisation->logo)->path;
        //Manipulating Job Data:
        $origDateposted = $oJob->dateposted;
        $origValidthrough = $oJob->validthrough;
        $origStartingfrom = $oJob->startingfrom;
        $oJob->dateposted = Date::parse('d.m.Y', $origDateposted);
        $oJob->validthrough = Date::parse('d.m.Y', $origValidthrough);
        $oJob->startingfrom = Date::parse('d.m.Y', $origStartingfrom);
        $oJob->Gdateposted = Date::parse('Y-m-d', $origDateposted);
        $oJob->Gvalidthrough = Date::parse('Y-m-d', $origValidthrough);
        $oJob->Gstartingfrom = Date::parse('Y-m-d', $origStartingfrom);
        if ($oJob->pdf) {
            $oJob->pdf = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oJob->pdf)->path;
        }
        if ($oJob->image) {
            $oJob->image = 'http://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid( $oJob->image )->path;
        }

         /* @var PageModel $objPage */
        global $objPage;

        $objPage->title = $oJob->title;
        $this->Template->organisation = $oParentOrganisation;
        $this->Template->job = $oJob;
    }
}
