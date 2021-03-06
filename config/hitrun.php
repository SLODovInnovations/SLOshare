<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enabled
    |--------------------------------------------------------------------------
    |
    | Hit and Run On / Off
    |
    */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Seedtime
    |--------------------------------------------------------------------------
    |
    | Min Seedtime Required In Seconds
    |
    */

    'seedtime' => 259200,

    /*
    |--------------------------------------------------------------------------
    | Max Warnings
    |--------------------------------------------------------------------------
    |
    | Max Warnings Before Ban
    |
    */

    'max_warnings' => 5,

    /*
    |--------------------------------------------------------------------------
    | Revoke Permissions
    |--------------------------------------------------------------------------
    |
    | Max Warnings Before Certain Permissions Are Revoked
    |
    */

    'revoke' => 3,

    /*
    |--------------------------------------------------------------------------
    | Grace Period
    |--------------------------------------------------------------------------
    |
    | Max Grace Time For User To Be Disconnected If "Seedtime" Value
    | Is Not Yet Met. "In Days"
    |
    */

    'grace' => 3,

    /*
    |--------------------------------------------------------------------------
    | Buffer
    |--------------------------------------------------------------------------
    |
    | Percentage Buffer of Torrent thats checked against 'actual_downloaded'
    |
    */

    'buffer' => 1,

    /*
    |--------------------------------------------------------------------------
    | Warning Expire
    |--------------------------------------------------------------------------
    |
    | Max Days A Warning Lasts Before Expiring "In Days"
    |
    */

    'expire' => 14,

    /*
    |--------------------------------------------------------------------------
    | Prewarn Period
    |--------------------------------------------------------------------------
    |
    | Max Time For User To Be Disconnected If "Seedtime" Value
    | Is Not Yet Met. A Prewarning PM Will Be Sent. "In Days"
    |
    */

    'prewarn' => 5,

];
