<?php

/**
 * @copyright  Sven Rhinow 2018 <https://www.sr-tag.de>
 * @author     Sven Rhinow
 * @package    srhinow/project-manager-bundle
 * @license    LGPL-3.0+
 * @see	       https://github.com/srhinow/project-manager-bundle
 *
 */

declare(strict_types=1);

namespace Srhinow\BeekeepingManagerBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

use Srhinow\BeekeepingManagerBundle\SrhinowBeekeepingManagerBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;

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


    /**
     * {@inheritDoc}
     */
    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel): ?RouteCollection
    {
        $loader = $resolver->resolve(__DIR__ . '/../Resources/config/routing.yml');
        if ($loader === false) {
            return null;
        }

        return $loader->load(__DIR__ . '/../Resources/config/routing.yml');
    }
}

