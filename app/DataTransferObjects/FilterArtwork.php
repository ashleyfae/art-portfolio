<?php
/**
 * FilterArtwork.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\DataTransferObjects;

use App\Http\Requests\FilterArtworkRequest;

class FilterArtwork
{
    public function __construct(
        public readonly bool $showAll,
        public readonly ?int $year = null,
        public readonly ?int $month = null
    ) {

    }

    public static function fromArray(array $args): static
    {
        return new static(
            showAll: ! empty($args['show_all']),
            year: ! empty($args['year']) ? (int) $args['year'] : null,
            month: ! empty($args['month']) ? (int) $args['month'] : null,
        );
    }
}
