<?php
/**
 * HasPath.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Models\Traits;

/**
 * @property-read string $path
 */
trait HasRoute
{
    public function getRoute(bool $absolute = true): string
    {
        return route($this->getTable().'.show', $this, $absolute);
    }

    public function getPathAttribute($value): string
    {
        return $this->getRoute();
    }
}
