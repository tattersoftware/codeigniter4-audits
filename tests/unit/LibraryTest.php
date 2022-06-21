<?php

use Tests\Support\DatabaseTestCase;
use Tests\Support\Models\WidgetModel;

/**
 * @internal
 */
final class LibraryTest extends DatabaseTestCase
{
    public function testSaves()
    {
        $widget = fake(WidgetModel::class);

        $this->seeInDatabase('widgets', (array) $widget);
    }
}
