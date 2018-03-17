<?php

/**
 * @copyright  Sven Rhinow 2018 <https://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    srhinow/project-manager-bundle
 * @license    LGPL-3.0+
 * @see	       https://github.com/srhinow/project-manager-bundle
 *
 */

namespace Srhinow\BeekeepingManagerBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

use Srhinow\BeekeepingManagerBundle\SrhinowBeekeepingManagerBundle;

/**
 * Plugin for the Contao Manager.
 *
 * @author Sven Rhinow
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(SrhinowBeekeepingManagerBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}

