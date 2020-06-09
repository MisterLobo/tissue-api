<?php

namespace Framework\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/sociallogin/google','/sociallogin/facebook','/sociallogin/github','/sociallogin/twitter','/sociallogin/vkontakte', '/social/*'
    ];
}
