<?php
namespace Digidennis\Minify\Eel;

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;

class Resource implements ProtectedContextAwareInterface
{

    /**
     * @var \Digidennis\Minify\MinifyProxy
     * @Flow\Inject
     */
    protected $minifyproxy;

    /**
     * All methods are considered safe, i.e. can be executed from within Eel
     *
     * @param string $methodName
     * @return boolean
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }


    public function output($type,$group)
    {
        return $this->minifyproxy->output($type,$group);
    }

    public function hasGroup($group)
    {
        return $this->minifyproxy->hasGroup($group);
    }
}