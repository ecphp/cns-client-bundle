<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\CnsClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('cns_client');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('base_url')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('system_key')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('system_password')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('group_code')->isRequired()->cannotBeEmpty()->end();

        return $treeBuilder;
    }
}
