<?php

return [
    /*
     * Browsershot akan mencari node di path ini.
     */
    'node_path' => env('BROWSERSHOT_NODE_PATH', null),

    /*
     * Browsershot akan mencari npm di path ini.
     */
    'npm_path' => env('BROWSERSHOT_NPM_PATH', null),

    /*
     * Timeout untuk generate PDF (detik)
     */
    'timeout' => env('BROWSERSHOT_TIMEOUT', 60),
];