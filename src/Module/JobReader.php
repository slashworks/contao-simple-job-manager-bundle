<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\Module;

use Contao\Controller;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\CoreBundle\Exception\RedirectResponseException;
use Contao\Date;
use Contao\FilesModel;
use Contao\Input;
use Contao\Module;
use Contao\System;
use Contao\PageModel;
use Contao\Environment;
use Contao\BackendTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs;
use Slashworks\ContaoSimpleJobManagerBundle\Models\Organisation;
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
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')))  {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate( 'be_wildcard' );
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

        $oJob = Jobs::findOneBy('alias', $aOptions['alias']);

        if ($oJob === null) {
            throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
        }

        if ($oJob->validthrough < time()) {
            throw new PageNotFoundException('Page not found: ' . Environment::get('uri'));
        }

        $oParentOrganisation = Organisation::findOneBy('id' , $oJob->pid);


        //Manipulating Organistaion Data:
        $oParentOrganisation->logo = 'https://' . $_SERVER['SERVER_NAME'] . '/' . FilesModel::findByUuid($oParentOrganisation->logo)->path;
        //Manipulating Job Data:
        $origDateposted = $oJob->dateposted;
        $origValidthrough = $oJob->validthrough;
        $origStartingfrom = $oJob->startingfrom;
        $oJob->dateposted = Date::parse('d.m.Y', $origDateposted);
//        $oJob->validthrough = Date::parse('d.m.Y', $origValidthrough);
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
        $objPage->pageTitle = ($oJob->metaTitle) ? $oJob->metaTitle : $oJob->title;
        $objPage->description = ($oJob->metaDescription) ? $oJob->metaDescription : '';

        $this->Template->organisation = $oParentOrganisation;
        $this->Template->job = $oJob;
    }
}
