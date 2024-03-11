<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateStatusUser
{
    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $res = $next($request);
        if (auth()->check()) {
            $this->model->updateStatus('1');
        } else {
            $this->model->updateStatus('0');
        }

        return $res;
    }
}
