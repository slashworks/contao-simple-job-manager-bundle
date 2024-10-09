<?php


use Contao\ModuleModel;

$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = array('tl_module_dca', 'adjustDcaByType');

// Add palette to tl_module
$GLOBALS['TL_DCA']['tl_module']['palettes']['job-list'] = '{title_legend},name,headline,type;{config_legend},organisation,expiredjob,jobsorting,sortorder,jumpTo;{template_legend},customTpl;{image_legend},imgSize;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['job-reader'] = '{title_legend},name,headline,type;{template_legend},customTpl;{expert_legend:hide},cssID,space';

// Add fields to tl_module
$GLOBALS['TL_DCA']['tl_module']['fields']['organisation'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['organisation'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('multiple' => true, 'mandatory' => true, 'tl_class' => 'w50'),
    'sql' => "blob NULL",
    'foreignKey' => 'tl_sjm_organisation.title',
);

$GLOBALS['TL_DCA']['tl_module']['fields']['expiredjob'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['expiredjob'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'w50'),
    'sql' => "int(1) NULL",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['jobsorting'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['jobsorting'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'select',
    'options' => $GLOBALS['sjm']['jobsorting']['options'],
    'reference' => &$GLOBALS['TL_LANG']['jobsorting'],
    'eval' => array('mandatory' => true, 'maxlength' => 64, 'tl_class' => 'clr w50'),
    'sql' => "varchar(64) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sortorder'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['sortorder'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'select',
    'options' => array('ASC', 'DESC'),
    'reference' => &$GLOBALS['TL_LANG']['sortorder'],
    'eval' => array('mandatory' => true, 'maxlength' => 64, 'tl_class' => 'w50'),
    'sql' => "varchar(64) NOT NULL default ''",
);


class tl_module_dca
{

    /**
     * Adjust the DCA by type
     *
     * @param object $dc
     */
    public function adjustDcaByType($dc)
    {
        $objMod = ModuleModel::findByPk($dc->id);

        if ($objMod === null) {
            return;
        }

        switch ($objMod->type) {
            case 'job-list':
                $GLOBALS['TL_DCA']['tl_module']['fields']['jumpTo']['eval']['tl_class'] = ' clr w50';

                break;

        }
    }

}

