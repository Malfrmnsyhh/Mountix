<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware {
  public function handle(Request $request, Closure $next, ...$roles) {
    $user = auth('api')->user();
    if (!$user || !in_array($user->role, $roles)) {
      return response()->json(['message' => 'Akses ditolak. Permissions tidak mencukupi.'], 403);
    }

    return $next($request);
  }
}