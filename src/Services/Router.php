<?php

namespace Boyarkin\App\Services;

use Boyarkin\App\Pages\NotFoundHttpException;

class Router
{
    private static array $list_urls = [];

    private static array $options = [];

    /**
     * @param $uri
     * @param $class_name
     * @return void
     */
    public static function RegisterPage($uri, $class_name): void
    {
        self::$list_urls[$uri] = [
            "class_name" => $class_name
        ];
    }

    /**
     * @param string $uri
     * @return void
     * @throws NotFoundHttpException
     */
    public static function SearchPage(string $uri): void
    {
        $uri = trim($uri, '/');
        $segments = explode('/', $uri);
        $uri = "/" . $uri;
        if ($uri === '/'){
            $class = self::GetClass($uri);
            if ($class && class_exists($class)){
                $root = new $class;
                $root->index();
            } else{
                throw new NotFoundHttpException('Page not found.');
            }
        } elseif (count($segments) < 2){
            $class = self::GetClass($uri);
            if ($class && class_exists($class) && method_exists($class, 'index')){
                $my_class = new $class;
                $my_class->index();
            } else{
                throw new NotFoundHttpException('Page not found.');
            }
        } else{
            $segments_reversed = array_reverse($segments);
            self::ExecuteMethod($segments_reversed);
            self::$options = [];
        }
    }

    /**
     * @param array $segments
     * @return void
     * @throws NotFoundHttpException
     */
    private static function ExecuteMethod(array $segments): void
    {
        $next_segment = 'index';
        self::$options = [];
        $isEnable = false;
        $list_uri = array_reverse($segments);
        foreach ($segments as $segment){
            $uri = "/" . implode('/', $list_uri);
            $class = self::GetClass($uri);
            $uri = trim($uri, "/");
            $list_uri = explode('/', $uri);
            array_pop($list_uri);
            $isEnable = self::EnableMethod($class, $next_segment, $isEnable);
            self::$options[] = $segment;
            $next_segment = $segment;
        }
        if (!$isEnable){
            throw new NotFoundHttpException('Page not found.');
        }
    }

    /**
     * @param string $uri
     * @return class-string|null
     */
    private static function GetClass(string $uri): ?string
    {
        return self::$list_urls[$uri]['class_name'] ?? null;
    }

    /**
     * @param class-string|null $class
     * @param string|null $method
     * @param boolean $flag
     * @return boolean
     */
    private static function EnableMethod(string|null $class, string|null $method, bool $flag): bool
    {
        $condition = $class && class_exists($class) && !$flag;
        if ($condition && method_exists($class, $method)) {
            array_pop(self::$options);
            $my_class = new $class;
            $my_class->$method(...array_reverse(self::$options));
            $flag = true;
        } elseif ($condition && method_exists($class, 'index')){
            $my_class = new $class;
            $my_class->index(...array_reverse(self::$options));
            $flag = true;
        }
        return $flag;
    }
}