<?php

namespace Happyr\EventTrackerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('happyr_event_tracker');
        $rootNode = $treeBuilder->getRootNode();
        

        $rootNode->children()
            ->append($this->getEventNode())
            ->enumNode('manager')->values(array('database', 'aggressive'))->defaultValue('database')->end()
        ->end();

        return $treeBuilder;
    }

    /**
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getEventNode()
    {
        $treeBuilder = new TreeBuilder('events');
        $node = $treeBuilder->getRootNode();
        $node
            ->isRequired()
            ->useAttributeAsKey('event')
            ->prototype('array')
            ->children()
                ->scalarNode('action')->isRequired()->end()
                ->scalarNode('namespace')->isRequired()->end()
                ->booleanNode('save_user')->defaultTrue()->end()
            ->end()
        ->end();

        return $node;
    }
}
