<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\Classes;

use Contao\Controller;
use Contao\FilesModel;
use Contao\StringUtil;
use Slashworks\ContaoSimpleJobManagerBundle\Models\Organisation;

/**
 * Provide methods to prepare and manipulate employee data for frontend usage.
 *
 * Class EmployeeHelper
 *
 * @package Slashworks\ContaoSimpleJobManagerBundle\Classes
 * @author  slashworks <hallo@slash-works.de>
 */
class OrganisationHelper
{

    /**
     * Global entry method to prepare and standardize employee data.
     *
     * @param       $oOrganisations
     * @param array $aConfiguration
     *
     * @throws \Exception
     */
    public static function prepareOrganisation($oOrganisations, array $aConfiguration = array())
    {
        if ($oOrganisations === null) {
            throw new \Exception('Keine Organisation übergeben.', 200);
        }

        foreach ($oOrganisations as $oOrganisation) {
            self::getOrganisationData($oOrganisation);
        }
    }

    protected function getOrganisationData(Organisation $oOrganisation)
    {
        return $oOrganisation;
    }
}
