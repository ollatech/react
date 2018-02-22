<?php

namespace Olla\React\Renderer;

use Nacmartin\PhpExecJs\PhpExecJs;
use Psr\Cache\CacheItemPoolInterface;
use Olla\React\Exception\EvalJsException;
use Olla\React\Render;


final class PhpExecRender implements Render
{
    protected $phpExecJs;

    public function __construct(PhpExecJs $phpExecJs)
    {
        $this->phpExecJs = $phpExecJs;
    }
    
    public function setCache(CacheItemPoolInterface $cache, $cacheKey)
    {
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
    }

   
    public function execute($component, string $filePath = null) {
        $result = json_decode($this->phpExecJs->evalJs($component), true);
        if ($result['hasErrors']) {

        }
        return [
            'html' => $result['html'],
            'hasErrors' => $result['hasErrors']
        ];
    }
}
