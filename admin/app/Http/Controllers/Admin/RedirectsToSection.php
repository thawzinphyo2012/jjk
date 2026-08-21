<?php

namespace App\Http\Controllers\Admin;

use App\Support\SectionRegistry;

trait RedirectsToSection
{
    protected function backToSection(string $routePrefix, string $message)
    {
        $section = SectionRegistry::sectionForRoutePrefix($routePrefix);

        if ($section) {
            return redirect()->route('admin.sections.edit', $section)->with('success', $message);
        }

        return redirect()->route('admin.'.$routePrefix.'.index')->with('success', $message);
    }
}
