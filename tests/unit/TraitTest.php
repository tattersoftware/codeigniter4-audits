<?php

use Tests\Support\DatabaseTestCase;
use Tests\Support\Models\WidgetModel;

/**
 * @internal
 */
final class TraitTest extends DatabaseTestCase
{
    public function testInsertAddsAudit()
    {
        $widget = $this->fabricator->make();

        $result = $this->model->insert($widget);
        $this->assertIsInt($result);

        $expected = [
            'source'    => 'widgets',
            'source_id' => $result,
            'event'     => 'insert',
            'summary'   => '5 fields',
            'user_id'   => 0,
        ];

        $queue = service('audits')->getQueue();

        $this->assertCount(1, $queue);
        $this->seeAudit($expected);
    }

    public function testUpdateAddsAudit()
    {
        $widget   = fake(WidgetModel::class);
        $widgetId = $widget->id; // @phpstan-ignore-line

        $this->model->update($widgetId, [
            'name' => 'Banana Widget',
        ]);

        $expected = [
            'source'    => 'widgets',
            'source_id' => [$widgetId],
            'event'     => 'update',
            'summary'   => '2 fields',
            'user_id'   => 0,
        ];

        $queue = service('audits')->getQueue();

        $this->assertCount(2, $queue);
        $this->seeAudit($expected);
    }
}
