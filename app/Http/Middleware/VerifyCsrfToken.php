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
        '/api/signup',
        '/api/login',
        '/api/edit_profile',
        '/api/get_category_list',
        '/api/set_favorite',
        '/api/del_favorite',
        '/api/get_favourite',
        '/api/logout',
        '/api/forget_pwd',
        '/api/get_outapp',
        '/api/get_animals',
        '/api/add_animal',
        '/api/update_animal',
        '/api/del_animal',
    ];
}
