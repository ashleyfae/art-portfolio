<?php

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\CanAccessInaccessibleMembers;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, LazilyRefreshDatabase, CanAccessInaccessibleMembers;
}
