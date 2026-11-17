<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Toggleable trades micro-SaaS modules
    |--------------------------------------------------------------------------
    | Plumbing, HVAC, and multi-trade owners enable only what their shop needs.
    */
    'customers' => [
        'enabled' => (bool) env('MODULE_CUSTOMERS', true),
        'name' => 'Customers & Properties',
        'description' => 'Homeowner and commercial accounts with service addresses, equipment notes, and contact history.',
        'category' => 'crm',
        'hours_saved_weekly' => 12,
        'core' => true,
    ],
    'dispatch' => [
        'enabled' => (bool) env('MODULE_DISPATCH', true),
        'name' => 'Dispatch Board',
        'description' => 'Same-day and scheduled job dispatch with trade type, priority, ETA, and technician assignment.',
        'category' => 'operations',
        'hours_saved_weekly' => 30,
        'core' => true,
    ],
    'estimates' => [
        'enabled' => (bool) env('MODULE_ESTIMATES', true),
        'name' => 'Estimates & Quotes',
        'description' => 'Line-item estimates for plumbing/HVAC jobs with deposit flags and conversion to invoices.',
        'category' => 'sales',
        'hours_saved_weekly' => 18,
        'core' => true,
    ],
    'invoicing' => [
        'enabled' => (bool) env('MODULE_INVOICING', true),
        'name' => 'Invoicing & Payments',
        'description' => 'Job-linked invoices, tax lines, balance due tracking, and Unicode PDF invoice packs.',
        'category' => 'finance',
        'hours_saved_weekly' => 16,
        'core' => true,
    ],
    'technician_app' => [
        'enabled' => (bool) env('MODULE_TECHNICIAN_APP', true),
        'name' => 'Technician Field App',
        'description' => 'Technician task queue with check-in, notes, parts used, and job completion from the truck.',
        'category' => 'field',
        'hours_saved_weekly' => 22,
        'core' => true,
    ],
    'plumbing_trade' => [
        'enabled' => (bool) env('MODULE_PLUMBING_TRADE', true),
        'name' => 'Plumbing Trade Pack',
        'description' => 'Plumbing-specific job types, leak/emergency presets, and fixture service catalogs.',
        'category' => 'trade',
        'hours_saved_weekly' => 10,
        'core' => false,
    ],
    'hvac_trade' => [
        'enabled' => (bool) env('MODULE_HVAC_TRADE', true),
        'name' => 'HVAC Trade Pack',
        'description' => 'HVAC diagnostics, seasonal maintenance plans, refrigerant notes, and equipment serial tracking.',
        'category' => 'trade',
        'hours_saved_weekly' => 10,
        'core' => false,
    ],
    'ai_assistant' => [
        'enabled' => (bool) env('MODULE_AI_ASSISTANT', true),
        'name' => 'AI Field Assistant',
        'description' => 'AI hub wiring for diagnose hints, estimate drafts, customer SMS replies, and job summaries.',
        'category' => 'ai',
        'hours_saved_weekly' => 20,
        'core' => false,
    ],
    'parts_catalog' => [
        'enabled' => (bool) env('MODULE_PARTS_CATALOG', true),
        'name' => 'Parts & Catalog',
        'description' => 'Parts SKUs with optional AI catalog scrape assist for supplier and OEM price sheets.',
        'category' => 'inventory',
        'hours_saved_weekly' => 14,
        'core' => false,
    ],
    'attendance_ops' => [
        'enabled' => (bool) env('MODULE_ATTENDANCE_OPS', false),
        'name' => 'Technician Attendance',
        'description' => 'Optional attendance hub bridge for clock-in, shop time, and overtime visibility.',
        'category' => 'workforce',
        'hours_saved_weekly' => 8,
        'core' => false,
    ],
    'speed_optimizer' => [
        'enabled' => (bool) env('MODULE_SPEED_OPTIMIZER', true),
        'name' => 'Drutogoti Speed Layer',
        'description' => 'Performance helpers for dispatch boards and technician mobile forms.',
        'category' => 'platform',
        'hours_saved_weekly' => 6,
        'core' => false,
    ],
    'unicode_docs' => [
        'enabled' => (bool) env('MODULE_UNICODE_DOCS', true),
        'name' => 'Unicode PDF Documents',
        'description' => 'Multilingual estimate and invoice PDFs via laravel-unicode-pdf.',
        'category' => 'documents',
        'hours_saved_weekly' => 9,
        'core' => false,
    ],
];
