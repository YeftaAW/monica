<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckVaultAccess
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
        $requestedVaultId = $request->route()->parameter('vault');

        $exists = DB::table('user_vault')->where([
            'user_id' => Auth::id(),
            'vault_id' => $requestedVaultId,
        ])->exists();

        abort_if(! $exists, 401);

        return $next($request);
    }
}
