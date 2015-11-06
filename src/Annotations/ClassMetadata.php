<?php


namespace Windqyoung\Utils\Annotations;



class ClassMetadata
{
    /**
     * The class name
     * @var String
     */
    private $name;

    /**
     * @var \ReflectionClass
     */
    private $reflClass;

    /**
     * @var array
     */
    private $classMetadata;

    /**
     * [属性 => [annotation,],]
     * @var array
     */
    private $propertyMetadata;

    /**
     * [方法 => [annotation,],]
     * @var array
     */
    private $methodMetadata;

    /**
     * Constructs a metadata for the given class.
     *
     * @param string $class
     */
    public function __construct($class)
    {
        $this->name = $class;
    }

    /**
     * @return the $classMetadata
     */
    public function getClassMetadata()
    {
        return $this->classMetadata;
    }

    /**
     * @return the $propertyMetadata
     */
    public function getPropertyMetadata($property = null)
    {
        if (! is_null($property))
        {
            return isset($this->propertyMetadata[$property])
                ? $this->propertyMetadata[$property]
                : [];
        }

        return $this->propertyMetadata;
    }

    /**
     * @return the $methodMetadata
     */
    public function getMethodMetadata($method = null)
    {
        if (! is_null($method))
        {
            return isset($this->methodMetadata[$method])
                ? $this->methodMetadata[$method]
                : [];
        }

        return $this->methodMetadata;
    }

    /**
     * @param array $classMetadata
     */
    public function setClassMetadata($classMetadata)
    {
        $this->classMetadata = $classMetadata;
    }

    public function setPropertyMetadata($property, $metadata)
    {
        $this->propertyMetadata[$property] = $metadata;
    }

    public function setMethodMetadata($method, $metadata)
    {
        $this->methodMetadata[$method] = $metadata;
    }

    public function getReflectionClass()
    {
        if (! $this->reflClass) {
            $this->reflClass = new \ReflectionClass($this->getClassName());
        }

        return $this->reflClass;
    }

    public function getClassName()
    {
        return $this->name;
    }
}