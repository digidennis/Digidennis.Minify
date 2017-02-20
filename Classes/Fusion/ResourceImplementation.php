<?php
/**
 * Created by PhpStorm.
 * User: digid
 * Date: 13-01-2017
 * Time: 08:30
 */

namespace Digidennis\Minify\Fusion;

use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Neos\Flow\Annotations as Flow;

class ResourceImplementation extends AbstractFusionObject
{
    /**
     * @var \Digidennis\Minify\MinifyProxy
     * @Flow\Inject
     */
    protected $minifyProxy;

    /**
     * @return mixed
     */
    public function evaluate()
    {
        $path = $this->fusionValue('path');
        if($path !== '')
        {
            $group = $this->fusionValue('group');
            if($group !== '')
                $this->minifyProxy->add($path,$group);
        }
        return '';
    }
}