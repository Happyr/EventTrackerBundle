<?php

namespace Happyr\EventTrackerBundle\DependencyInjection;

use Happyr\EventTrackerBundle\Manager\EventTrackerManagerInterface;
use Happyr\EventTrackerBundle\Service\EventListener;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class HappyrEventTrackerExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $listener = $container->getDefinition(EventListener::class);

        $eventMap = array();
        foreach ($config['events'] as $name => $event) {
            $listener->addTag('kernel.event_listener', array('event' => $name, 'method' => 'createLog'));
            $eventMap[$name] = array('action' => $event['action'], 'namespace' => $event['namespace']);
        }

        //add the event map to the listener
        $listener->replaceArgument(2, $eventMap);

        $container->setAlias('happyr.event_tracker.manager', 'happyr.event_tracker.manager.'.$config['manager']);
        $container->setAlias(EventTrackerManagerInterface::class, 'happyr.event_tracker.manager.'.$config['manager']);
    }
}
