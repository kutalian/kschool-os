<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->safeIndex('attendance', ['date']);
        $this->safeIndex('attendance', ['status']);
        $this->safeIndex('staff_attendances', ['date']);
        $this->safeIndex('staff_attendances', ['status']);
        $this->safeIndex('staff', ['role_type']);
        $this->safeIndex('staff', ['is_active']);
        $this->safeIndex('students', ['is_active']);
        $this->safeIndex('cms_pages', ['is_active']);
        $this->safeIndex('website_content', ['section_key']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropSafeIndex('website_content', ['section_key']);
        $this->dropSafeIndex('cms_pages', ['is_active']);
        $this->dropSafeIndex('students', ['is_active']);
        $this->dropSafeIndex('staff', ['role_type']);
        $this->dropSafeIndex('staff', ['is_active']);
        $this->dropSafeIndex('staff_attendances', ['date']);
        $this->dropSafeIndex('staff_attendances', ['status']);
        $this->dropSafeIndex('attendance', ['date']);
        $this->dropSafeIndex('attendance', ['status']);
    }

    private function safeIndex(string $table, array $columns)
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $indexName = $table . '_' . implode('_', $columns) . '_index';
        $existingIndexes = collect(Schema::getIndexes($table))->pluck('name')->toArray();

        if (!in_array($indexName, $existingIndexes)) {
            Schema::table($table, function (Blueprint $table) use ($columns) {
                $table->index($columns);
            });
        }
    }

    private function dropSafeIndex(string $table, array $columns)
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $indexName = $table . '_' . implode('_', $columns) . '_index';
        $existingIndexes = collect(Schema::getIndexes($table))->pluck('name')->toArray();

        if (in_array($indexName, $existingIndexes)) {
            Schema::table($table, function (Blueprint $table) use ($indexName) {
                $table->dropIndex($indexName);
            });
        }
    }
};
