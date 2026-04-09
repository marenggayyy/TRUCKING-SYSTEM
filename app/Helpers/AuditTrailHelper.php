<?php

use App\Models\AuditTrail;

if (!function_exists('audit_log')) {
    function audit_log($action, $description, $model = null, $old = null, $new = null)
    {
        try {
            // ✅ ensure model exists
            if (!class_exists(\App\Models\AuditTrail::class)) {
                return;
            }

            \App\Models\AuditTrail::create([
                'user_id'     => auth()->id(),
                'action'      => $action,
                'model_type'  => $model ? get_class($model) : null,
                'model_id'    => $model->id ?? null,
                'description' => $description,
                'old_values'  => $old ? json_encode($old) : null,
                'new_values'  => $new ? json_encode($new) : null,
            ]);

        } catch (\Throwable $e) {
            // ❌ never break app
        }
    }
}