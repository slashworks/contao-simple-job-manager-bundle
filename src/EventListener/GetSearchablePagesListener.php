<?php

namespace Slashworks\ContaoSimpleJobManagerBundle\EventListener;

use Contao\ContentModel;
use Contao\Date;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Slashworks\ContaoSimpleJobManagerBundle\Models\Jobs;

class GetSearchablePagesListener
{
    /**
     * @param array $pages
     * @param int|null $rootId
     * @param bool $isSitemap
     * @param string $language
     * 
     * @return array
     */
    public function __invoke($pages, $rootId = null, $isSitemap = false, $language = null)
    {
        // Load all job list modules
        $modules = ModuleModel::findByType('job-list');

        if (null === $modules) {
            return $pages;
        }

        $detailPageIds = [];

        foreach ($modules as $module) {
            // Check if the module has a detail page defined
            if (empty($module->jumpTo)) {
                continue;
            }

            // Find all content elements integrating this module
            $time = Date::floorToMinute();
            $elements = ContentModel::findBy([
                "invisible='' AND (start='' OR start<='$time') AND (stop='' OR stop>'$time')",
                "type = 'module'", 
                "ptable = 'tl_article'",
                'module = ?',
            ], [$module->id]);

            if (null === $elements) {
                continue;
            }

            // Check if we already processed this detail page
            if (\in_array((int) $module->jumpTo, $detailPageIds, true)) {
                continue;
            }

            $detailPageIds[] = (int) $module->jumpTo;
            $page = PageModel::findPublishedById((int) $module->jumpTo);

            if (null === $page) {
                continue;
            }

            // Check if indexing is disabled
            if ('noindex,nofollow' === $page->robots) {
                continue;
            }

            $page->loadDetails();

            // Check if page belongs to current root
            if (null !== $rootId && (int) $rootId !== (int) $page->rootId) {
                continue;
            }

            // Load all jobs for this list
            $organisations = StringUtil::deserialize($module->organisation, true);

            if (empty($organisations)) {
                continue;
            }

            $jobs = Jobs::findBy(['pid IN('.implode(',', array_map('intval', $organisations)).')'], []);

            if (null === $jobs) {
                continue;
            }

            foreach ($jobs as $job) {
                $pages[] = $page->getAbsoluteUrl('/'.$job->alias);
            }
        }

        return $pages;
    }
}
