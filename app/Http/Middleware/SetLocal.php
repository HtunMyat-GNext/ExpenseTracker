<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
class SetLocal
{
    public function handle($request, Closure $next)
    {
        $locale = Session::get('locale') ?? 'en';
        Session::put('locale', $locale);
        App::setLocale($locale);
        
        return $next($request);
    }
}
