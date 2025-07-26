<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Models\admin\Statistic;

class TrackStatistics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $url = $request->url();

        if (str_contains($url, '/admin') || str_contains($url, '/getBanner') || str_contains($url, '/getService') || str_contains($url, '/getProject') || str_contains($url, '/getBlog') || str_contains($url, '/getGallery') || str_contains($url, '/count') || str_contains($url, '/{any}/fetchData') || str_contains($url, '/{any}/{any}/comment') || str_contains($url, '/{any}/getService') || str_contains($url, '/service/getClient') || str_contains($url, '/about/getAbout')) {
            return $next($request);
        } else {
            $statistics = new Statistic();
            $statistics->ip_address = $request->ip();
            $statistics->url = str_replace(route('web.index'), '', $url);

            $agent = new Agent();
            $statistics->device = $agent->device();
            $statistics->platform = $agent->platform();
            $statistics->browser = $agent->browser();
            $statistics->visit_time = now();
            $statistics->save();
        }

        return $next($request);
    }
}
