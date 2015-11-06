<?php


namespace Windqyoung\Utils\Annotations;


use Doctrine\Common\Annotations\Reader;


class AnnotationLoader
{
    /**
     * @var Reader
     */
    protected $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param ClassMetadata $metadata
     * @return ClassMetadata
     */
    public function loadClassMetadata(ClassMetadata $metadata)
    {
        $reflClass = $metadata->getReflectionClass();
        $className = $reflClass->name;

        $metadata->setClassMetadata($this->reader->getClassAnnotations($reflClass));

        foreach ($reflClass->getProperties() as $property)
        {
            /**
             * @var $property \ReflectionProperty
             */
            if ($property->getDeclaringClass()->name === $className)
            {
                $metadata->setPropertyMetadata(
                    $property->name,
                    $this->reader->getPropertyAnnotations($property)
                );
            }
        }

        foreach ($reflClass->getMethods() as $method)
        {
            /**
             * @var $method \ReflectionMethod
             */
            if ($method->getDeclaringClass()->name === $className)
            {
                $metadata->setMethodMetadata(
                    $method->name,
                    $this->reader->getMethodAnnotations($method)
                );
            }
        }

        return $metadata;
    }
}