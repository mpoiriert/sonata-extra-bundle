<?php

namespace Draw\Bundle\SonataExtraBundle\EventListener;

use Draw\Bundle\SonataExtraBundle\Event\FormContractorDefaultOptionsEvent;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AutoHelpListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormContractorDefaultOptionsEvent::class => 'configureHelp',
        ];
    }

    public function configureHelp(FormContractorDefaultOptionsEvent $event): void
    {
        $fieldDescription = $event->getFieldDescription();

        $class = $fieldDescription->getAdmin()->getClass();

        if (!$class) {
            return;
        }

        $defaultOptions = $event->getDefaultOptions();

        if ($help = $this->extractHelp($class, $fieldDescription->getName())) {
            $defaultOptions['help'] = $help;
        }

        $event->setDefaultOptions($defaultOptions);
    }

    private function extractHelp(string $class, string $propertyName): string
    {
        $mainReflectionClass = $reflectionClass = new \ReflectionClass($class);

        do {
            if ($reflectionClass->hasProperty($propertyName)) {
                $property = $reflectionClass->getProperty($propertyName);
                if (false !== $docComment = $property->getDocComment()) {
                    $docBlock = DocBlockFactory::createInstance()->create($docComment);
                    if ($result = $docBlock->getSummary()) {
                        return $result;
                    }
                }
            }
        } while ($reflectionClass = $reflectionClass->getParentClass());

        if ($mainReflectionClass->hasMethod('getTranslationEntityClass')) {
            return $this->extractHelp(
                $mainReflectionClass->getMethod('getTranslationEntityClass')->invoke(null),
                $propertyName
            );
        }

        return '';
    }
}
