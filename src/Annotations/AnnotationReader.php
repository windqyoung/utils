<?php


namespace Windqyoung\Utils\Annotations;


use Doctrine\Common\Annotations\AnnotationReader as BaseReader;
use Doctrine\Common\Annotations\AnnotationRegistry;



AnnotationRegistry::registerLoader(function ($class_name) {
    return class_exists($class_name);
});


class AnnotationReader extends BaseReader
{
    /**
     * @param string $class
     */
    public function getClassMetadata($class)
    {
        $loader = new AnnotationLoader($this);

        $metadata = new ClassMetadata($class);

        return $loader->loadClassMetadata($metadata);
    }
}