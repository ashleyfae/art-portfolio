<?php
/**
 * ImageDimensions.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\DataTransferObjects;

class ImageDimensions
{
    public function __construct(
        public readonly ?int $width,
        public readonly ?int $height,
        public readonly ?string $mime,
    ) {

    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data[0] ?? null,
            $data[1] ??  null,
            $data['mime'] ?? null
        );
    }
}
