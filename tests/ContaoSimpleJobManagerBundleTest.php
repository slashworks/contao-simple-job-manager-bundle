<?php

/*
 * This file is part of [package name].
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace Slashworks\ContaoSimpleJobManagerBundle\Tests;

use Slashworks\ContaoSimpleJobManagerBundle\ContaoSimpleJobManagerBundle;
use PHPUnit\Framework\TestCase;

class ContaoSimpleJobManagerBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoSimpleJobManagerBundle();

        $this->assertInstanceOf('Slashworks\ContaoSimpleJobManagerBundle\ContaoSimpleJobManagerBundle', $bundle);
    }
}
