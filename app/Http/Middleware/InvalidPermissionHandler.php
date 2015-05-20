<?php  namespace App\Http\Middleware;

use App\Exceptions\InvalidPermissionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidPermissionHandler
{
    public function handle(Request $req, $next)
    {
        try {
            return $next($req);
        } catch (InvalidPermissionException $e) {
            if ($req->ajax()) {
                return new JsonResponse(
                    [
                        'error' => 'Insufficient permissions for this resource',
                        'action' => $e->action,
                        'resource' => $e->resource,
                    ], 403);
            } else {
                return redirect()->back()
                    ->with('warning', 'Insufficient permissions for this resource.');
            }
        }
    }
}
