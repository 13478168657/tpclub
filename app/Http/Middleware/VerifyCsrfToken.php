<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'course/notify',
        'course/notifyh',
        'wxinfo',
        '/wechat/*',
        'api/ureserve',
        'train/notify',
        'train/notifyh',
        'dist/payW/notify',
        'dist/payH/notify',
        'dist/team/*',
        'activeCourse/acsm/notifyh',
        'activeCourse/acsm/notify',
        'activeCourse/notify',
        'activeCourse/notifyh',
        "/team/train/*",
        "team/train/notify",
        "team/train/notifyh",
        'sy/active/*',
        'unline/exam/notify*',
        "tf/notify",
        "tf/notifyh"
    ];
}
