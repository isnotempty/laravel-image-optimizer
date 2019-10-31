<?php

namespace Spatie\LaravelImageOptimizer\Middlewares;

use Closure;
use Spatie\ImageOptimizer\OptimizerChain;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OptimizeImages
{
    public function handle($request, Closure $next)
    {
        $optimizerChain = app(OptimizerChain::class);

        collect($request->allFiles())
            ->flatten()
            ->each(function (UploadedFile $file) use ($optimizerChain) {
                if ($file->isValid()) {
                    $optimizerChain->optimize($file->getPathname());
                }
            });

        return $next($request);
    }
}
