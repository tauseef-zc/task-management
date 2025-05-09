<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\AuthFactoriesTrait;
use Tests\Traits\TaskFactoriesTrait;

abstract class TestCase extends BaseTestCase
{
    use WithFaker, AuthFactoriesTrait, TaskFactoriesTrait;
}
