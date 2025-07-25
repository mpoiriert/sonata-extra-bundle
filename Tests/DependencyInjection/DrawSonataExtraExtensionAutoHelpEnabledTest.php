<?php

namespace Draw\Bundle\SonataExtraBundle\Tests\DependencyInjection;

use Draw\Bundle\SonataExtraBundle\DependencyInjection\DrawSonataExtraExtension;
use Draw\Bundle\SonataExtraBundle\EventListener\AutoHelpListener;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * @internal
 */
class DrawSonataExtraExtensionAutoHelpEnabledTest extends DrawSonataExtraExtensionTest
{
    public function createExtension(): Extension
    {
        return new DrawSonataExtraExtension();
    }

    public function getConfiguration(): array
    {
        return [
            ...parent::getConfiguration(),
            'auto_help' => [
                'enabled' => true,
            ],
        ];
    }

    public static function provideServiceDefinitionCases(): iterable
    {
        yield from parent::provideServiceDefinitionCases();
        yield [AutoHelpListener::class];
    }
}
