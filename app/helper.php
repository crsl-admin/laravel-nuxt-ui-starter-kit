<?php

use Inertia\Inertia;

if (! function_exists('toast')) {
    /**
     * @param $message
     * @param string $type
     * @param string|null $color
     * @param string|null $body
     * @param string|null $icon
     * @return void
     */
    function toast(string $message, string $type = 'success', ?string $color = null, ?string $body = null, ?string $icon = null): void
    {
        Inertia::flash('toast', [
            'message' => $message,
            'type' => $type,
            'color' => $color,
            'body' => $body,
            'icon' => $icon,
        ]);
    }
}
