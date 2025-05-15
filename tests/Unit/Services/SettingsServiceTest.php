<?php

namespace Tests\Unit\Services;

use App\Models\Settings;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SettingsServiceTest extends TestCase
{
    use RefreshDatabase;

    private SettingsService $settingsService;

    public function setUp(): void
    {
        parent::setUp();
        $this->settingsService = App::make(SettingsService::class);
    }

    public function test_getData_return_data_from_database(): void
    {
        Settings::factory()->create(['key' => 'primary_color', 'value' => 'red', 'cacheable' => 0]);

        $result = $this->settingsService->getData('primary_color');

        $this->assertEquals('red', $result);
    }

    public function test_delete_return_false_if_setting_not_in_cache(): void
    {
        Settings::factory()->create(['key' => 'primary_color', 'value' => 'red', 'cacheable' => 0]);

        $this->settingsService->getData('primary_color');
        $result = $this->settingsService->delete('primary_color');

        $this->assertFalse($result);
    }

    public function test_getData_return_true_if_setting_is_cacheable_and_gets_deleted(): void
    {
        Settings::factory()->create(['key' => 'primary_color', 'value' => 'red', 'cacheable' => 1]);

        $this->settingsService->getData('primary_color');
        $result = $this->settingsService->delete('primary_color');

        $this->assertTrue($result);
    }

    public function test_getData_return_value_from_selected_cache_key(): void
    {
        $this->settingsService->put('key_val', 'value_val');

        $result = $this->settingsService->getData('key_val');

        $this->assertEquals('value_val', $result);
    }

    public function test_getData_return_value_set_to_default_parameter(): void
    {
        $result = $this->settingsService->getData('test', 'default_value');

        $this->assertEquals('default_value', $result);
    }

    public function test_getData_table_update_event_sync_with_cache(): void
    {
        Settings::factory()->create(['key' => 'key_val', 'value' => 'test', 'cacheable' => 1]);
        Settings::where('key', 'key_val')->update(['value' => 'new_val']);

        $updatedValue = $this->settingsService->getData('key_val');

        $this->assertEquals('new_val', $updatedValue);
    }

    public function test_getData_table_delete_event_sync_with_cache(): void
    {
        Settings::factory()->create(['key' => 'key_val', 'value' => 'test', 'cacheable' => 1]);

        Settings::where('key', 'key_val')->delete();

        $data = $this->settingsService->getData('key_val');

        $this->assertNull($data);
    }

    public function test_getData_after_table_update_returns_saved_cache(): void
    {
        $settings = Settings::factory()->create(['key' => 'key_val', 'value' => 'test', 'cacheable' => 1]);
        $beforeUpdateResult = $this->settingsService->getData('key_val');

        DB::table($settings->getTable())->where('key', 'key_val')->update(['value' => 'pepe']);

        $result = $this->settingsService->getData('key_val');

        $this->assertEquals($beforeUpdateResult, $result);
        $this->assertEquals('test', $result);
    }

    public function test_update_cache(): void
    {
        $this->settingsService->put('test-value', 'user');
        $result = $this->settingsService->getData('test-value');

        $this->settingsService->put('test-value', 'definitely-not-user');
        $updateResult = $this->settingsService->getData('test-value');

        $this->assertEquals('definitely-not-user', $updateResult);
        $this->assertEquals('user', $result);
    }
}
