<?php

namespace App\Http\Middleware;

use App\Models\Broadcast;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaskesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role == 3 || Auth::user()->role == 5 || Auth::user()->role == 2) {
            $pesan = Broadcast::where('jenis', 1)->whereDATE('batas', '>=', date('Y-m-d'))->get();
            \View::share('pesan', $pesan);
            return $next($request);
        }
        abort(404);
    }
}
