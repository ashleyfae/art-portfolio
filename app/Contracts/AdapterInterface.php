<?php
/**
 * AdapterInterface.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Contracts;

interface AdapterInterface
{
    public function convertFromSource(): mixed;
}
