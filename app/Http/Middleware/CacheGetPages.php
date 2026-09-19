<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CacheGetPages
{
   public function handle($request, Closure $next)
{
    // نتعامل فقط مع الطلبات GET
    if (!$request->isMethod('get')) {
        return $next($request);
    }

    // استثناء مسارات معينة: الأدمن، الكرون، ratesexchange
    if (
        $request->is('damas-administrator/*') || 
        $request->is('cron_*') || 
        $request->is('currency*') || 
        $request->is('confirmation*') || 
        $request->is('call_country*') ||
        $request->is('whatsapp*') ||
        $request->is('ajax/call_country*') || 
        $request->is('ratesexchange*') ||
        $request->is('webhooks/whatsapp')
    ) {
        return $next($request);
    }

    // مفتاح الكاش مبني على الرابط الكامل مع query string
    $key = 'page_cache_' . md5($request->fullUrl());

    // تهيئة عدادات HIT و MISS إذا لم تكن موجودة
    if (!Cache::has('cache_hits')) {
        Cache::forever('cache_hits', 0);
    }
    if (!Cache::has('cache_misses')) {
        Cache::forever('cache_misses', 0);
    }

    if (Cache::has($key)) {
        // HIT
        Cache::increment('cache_hits');

        $cached = Cache::get($key);

        // تحديد نوع المحتوى حسب الكاش (HTML أو JSON)
        $contentType = $this->detectContentType($cached);

        $response = response($cached)->header('Content-Type', $contentType);
        $response->headers->set('X-Page-Cache', 'HIT');
        return $response;
    }

    // MISS → استدعاء الكود الأصلي لإنشاء الصفحة
    $response = $next($request);

    // نخزن إذا كان الرد HTML أو JSON مع الحالة المناسبة
    $contentType = $response->headers->get('Content-Type');
    if (
        in_array($response->getStatusCode(), [200, 404]) &&
        (
            str_contains($contentType, 'text/html') ||
            str_contains($contentType, 'application/json')
        )
    ) {
        // تخزين المحتوى
        
        
        if(in_array($response->getStatusCode(), [200])){
            Cache::put($key, $response->getContent(), Carbon::now()->addMinutes(60*24*30));
        }else {//404
            Cache::put($key, $response->getContent(), Carbon::now()->addMinutes(60*24*30));
        }
        

        // زيادة عداد MISS
        Cache::increment('cache_misses');
    }

    // إضافة Header لتوضيح حالة الكاش
    $response->headers->set('X-Page-Cache', 'MISS');

    return $response;
}

/**
 * دالة لتحديد نوع المحتوى للكاش عند الاسترجاع
 */
private function detectContentType($cachedContent)
{
    // حاول تحويله إلى JSON، إذا نجح نعتبره JSON
    json_decode($cachedContent);
    if (json_last_error() === JSON_ERROR_NONE) {
        return 'application/json';
    }

    // خلاف ذلك HTML
    return 'text/html; charset=UTF-8';
}
}
