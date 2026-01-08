<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IncreasePostMaxSize
{
    public function handle(Request $request, Closure $next)
    {
        // Only override if current limits are too small
        $currentUpload = $this->sizeToBytes(ini_get('upload_max_filesize'));
        $currentPost = $this->sizeToBytes(ini_get('post_max_size'));
        
        if ($currentUpload < 50 * 1024 * 1024) { // Less than 50MB
            @ini_set('upload_max_filesize', '100M');
        }
        
        if ($currentPost < 50 * 1024 * 1024) { // Less than 50MB
            @ini_set('post_max_size', '100M');
        }
        
        @ini_set('max_execution_time', '300');
        @ini_set('max_input_time', '300');
        @ini_set('memory_limit', '256M');
        
        return $next($request);
    }
    
    private function sizeToBytes($size)
    {
        if (empty($size)) return 0;
        
        $size = trim($size);
        $last = strtolower($size[strlen($size)-1]);
        $size = (int) $size;
        
        switch($last) {
            case 'g':
                $size *= 1024;
            case 'm':
                $size *= 1024;
            case 'k':
                $size *= 1024;
        }
        
        return $size;
    }
}