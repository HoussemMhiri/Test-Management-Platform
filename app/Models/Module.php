<?php

namespace App\Models;

class Module
{
    public function getModules($moduleName = null)
    {
        $modules = [
            [
                "code"                              => "users",
                "module_name"                       => trans('users.module_name'),
                "module_description"                => trans('users.module_description'),
                "image"                             => asset('/images/module_icons/users.png'),
                "index_route"                       => "/users",
                "have_access"                       => true,
            ],
        ];

        return $moduleName ? collect($modules)->where('code', $moduleName)->first() : $modules;
    }
}
