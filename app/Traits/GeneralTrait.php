<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait GeneralTrait {

    public function generateSlug($string)
    {
        $model = get_class($this);
        $slug = Str::slug($string, '-');

        $allSlugs = $model::select('slug')
                            ->where('slug', 'like', $slug.'%')
                            ->where('id', '<>', $this->id)
                            ->get();

        // if no matching slug is found, return the slug

        if (! $allSlugs->contains('slug', $slug)) return $slug;

        // if a matching slug is found, append an incrementing number to the slug

        $i = 1;
        $contains = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $contains = false;
                return $newSlug;
            }
            $i++;
        } while ($contains);
    }

}

