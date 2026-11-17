<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_marketing_pages_respond_successfully(): void
    {
        $this->seed();

        foreach (['/', '/features', '/modules', '/dispatch', '/estimates', '/pricing', '/demo'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}
