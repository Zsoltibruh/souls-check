<?php

declare(strict_types=1);

namespace App\Presentation\Layout;

use Yiisoft\Assets\AssetBundle;

final class HtmxAsset extends AssetBundle
{
    public bool $cdn = true;

    public array $js = [
        'https://cdn.jsdelivr.net/npm/htmx.org@2.0.10/dist/htmx.min.js',
    ];

    public array $jsOptions = [
        'integrity' => 'sha384-H5SrcfygHmAuTDZphMHqBJLc3FhssKjG7w/CeCpFReSfwBWDTKpkzPP8c+cLsK+V',
        'crossorigin' => 'anonymous',
    ];
}
