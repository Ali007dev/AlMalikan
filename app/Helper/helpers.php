<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


if (!function_exists('transMsg')) {
    /**
     * @return string
     * @var array $parameters is the parameter you want to send to trans msg
     * (start with upper case letter and the rest chars lower case)
     * @var string $translateString the string we want to translate it
     */
    function transMsg($translateString, array $parameters = [])
    {
        return trans('messages.' . $translateString, $parameters);

    }
}

if (!function_exists('transKeys')) {
    /**
     * @return string
     * @var array $parameters is the parameter you want to send to trans msg
     * (start with upper case letter and the rest chars lower case)
     * @var string $translateString the string we want to translate it
     */
    function transKeys($translateString, array $parameters = [])
    {
        return trans('keys.' . $translateString, $parameters);

    }
}

if (!function_exists('transResponse')) {
    /**
     * @return string
     * @var array $parameters is the parameter you want to send to trans msg
     * (start with upper case letter and the rest chars lower case)
     * @var string $translateString the string we want to translate it
     */
    function transResponse($translateString, array $parameters = [])
    {
        return trans('response.' . $translateString, $parameters);

    }
}

if (!function_exists('throwError')) {
    /**
     * This method just for debug
     */
    function throwError($object): string
    {
        throw new \App\Exceptions\ErrorMsgException($object);
    }
}


if (!function_exists('changeLang')) {
    function changeLang(string $lang = 'en'): void
    {
        App::setLocale($lang);
    }
}

if (!function_exists('snakeCase')) {
    /**
     * Convert a string to snake case.
     *
     * @param string $value
     * @return string
     */
    function snakeCase($value)
    {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1_', $value));
        }
        return $value;
    }
}

if (!function_exists('kebabCase')) {
    /**
     * Convert a string to kebab case.
     *
     * @param string $value
     * @return string
     */
    function kebabCase($value)
    {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1-', $value));
        }
        return $value;
    }
}

if (!function_exists('pascalCase')) {
    /**
     * Convert a string to Pascal case.
     *
     * @param string $value
     * @return string
     */
    function pascalCase($value)
    {
        $value = snakeCase($value);
        $value = str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));

        return $value;
    }
}

if (!function_exists('camelCase')) {
    /**
     * Convert a string to camel case.
     *
     * @param string $value
     * @return string
     */
    function camelCase($value)
    {
        $value = pascalCase($value);
        $value = lcfirst($value);

        return $value;
    }
}

if (!function_exists('pascalCaseWithSpaces')) {
    /**
     * Convert a snake_case string to Pascal case with spaces.
     *
     * @param string $value
     * @return string
     */
    function pascalCaseWithSpaces($value)
    {
        return preg_replace('/([a-z])([A-Z])/', '$1 $2', pascalCase($value));
    }
}

if (!function_exists('getEnumValues')) {
    function getEnumValues($enum): array
    {
        return enum_exists($enum)
            ? array_column($enum::cases(), 'value')
            : [];
    }
}

if (!function_exists('storeFile')) {
    function storeFile($path, $file)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }
}
if (!function_exists('greaterDate')) {
    /**
     * Return the greater of two dates.
     *
     * @param string $date1
     * @param string $date2
     * @return string
     */
    function greaterDate($date1, $date2)
    {
        $carbonDate1 = Carbon::parse($date1);
        $carbonDate2 = Carbon::parse($date2);

        return $carbonDate1->greaterThan($carbonDate2) ? $date1 : $date2;
    }
}
if (!function_exists('diffDateByYear')) {
    function diffDateByYear($from_date, $to_date)
    {
        return Carbon::parse($from_date)->diff($to_date)->y;
    }
}
if (!function_exists('diffDateByMonth')) {
    function diffDateByMonth($from_date, $to_date)
    {
        return Carbon::parse($from_date)->diff($to_date)->m;
    }
}

if (!function_exists('diffDateByDay')) {
    function diffDateByDay($from_date, $to_date)
    {
        return Carbon::parse($from_date)->diff($to_date)->days;
    }
}

if (!function_exists('getArg')) {
    function getArg(string $key, mixed ...$args): mixed
    {
        $args = $args[0];

        foreach ($args as $arg) {
            if (is_array($arg) && isset($arg[$key])) {
                return $arg[$key];
            }
        }

        return null;
    }
}

if (!function_exists('makePaginator')) {
    function makePaginator($items, $perPage = 10,)
    {
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $paginatedItems = array_slice($items, $offset, $perPage);
        $paginator = new LengthAwarePaginator(
            $paginatedItems,
            count($items),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        return $paginator;
    }
}

