<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class UserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        if($user && $user->status !== '1'){
            Session::flash('error', 'Your account is not active. Please contact support.');

            // Redirect the user to a specific route or previous route
            return redirect()->back();
        }

        return $next($request);
    }
}
