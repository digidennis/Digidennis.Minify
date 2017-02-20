<?php
namespace Digidennis\Minify;

use Neos\Flow\Annotations as Flow;
use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;
/**
 * Class MinifyProxy
 * @Flow\Scope("singleton")
 */
class MinifyProxy
{
    const MNINIFYPATH = '_Resources/Static/Packages/Digidennis.Minify/Cached/';
    protected $groups;
    protected $minifyCss;
    protected $minifyJs;

    /**
     * @Flow\InjectConfiguration("cached")
     * @var bool
     */
    protected $cached;

    public function __construct()
    {
        $this->groups = array();
        $this->minifyCss = new CSS();
        $this->minifyJs = new JS();
    }

    public function add($filename, $group)
    {
        $pathinwebfolder = strstr($filename, '_Resources' );
        $ext = strtolower( pathinfo($filename, PATHINFO_EXTENSION));
        $this->groups[$group][] = $pathinwebfolder;

        if($this->cached)
        {
            if( $ext === 'css' )
            {
                $this->minifyCss->add($pathinwebfolder);
            }
            else if( $ext === 'js' )
            {
                $this->minifyJs->add($pathinwebfolder);
            }
        }

    }

    /**
     * @param string $type
     * @param string $group
     * @return array
     */
    public function output($type, $group)
    {
        $resources = array();
        if (!$this->hasGroup($group))
            return $resources;

        if ($this->cached)
        {
            $cachedfilename = '';

            foreach ($this->groups[$group] as $path) {
                $cachedfilename .= crc32($path);
                if (next($this->groups[$group]))
                    $cachedfilename .= '_';
            }
            $resultpath = $this::MNINIFYPATH . $cachedfilename . '.' . $type;

            if ($type === 'css') {
                $this->minifyCss->minify($resultpath);
            } else if ($type === 'js') {
                $this->minifyJs->minify($resultpath);
            }

            $resources[] =  $resultpath;
        }
        else
        {
            $resources = $this->groups[$group];
        }
        return $resources;
    }

    public function hasGroup($group)
    {
        return array_key_exists($group, $this->groups);
    }
}