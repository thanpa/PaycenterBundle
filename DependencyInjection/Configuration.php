<?php

namespace Thanpa\PaycenterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('thanpa_paycenter');

        $rootNode
            ->children()
                ->scalarNode('acquirerId')
                    ->info('Your Acquirer Id provided by bank.')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('merchantId')
                    ->info('Your Merchant Id provided by bank.')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('posId')
                    ->info('Your Pos Id provided by bank.')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('username')
                    ->info('Your API Username provided by bank.')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('password')
                    ->info('Your API Password provided by bank.')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('param_back_link')
                    ->info('Its contents will be used as a query string in the URL returned to the user when the "Cancel" button is pressed.')
                    ->defaultNull()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
