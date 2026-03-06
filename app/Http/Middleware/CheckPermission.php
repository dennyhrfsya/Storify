<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $module, $action): Response
    {
        $role = Auth::user()->role;

        $perm = Permission::where('role', $role)
            ->where('module', $module)
            ->first();

        if (!$perm || !$perm->$action) {
            return response()->view('errors.403', [
                'action' => $action,
                'module' => $module,
            ], 403);
        }

        return $next($request);
    }
}
