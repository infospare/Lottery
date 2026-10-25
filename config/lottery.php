<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Lottery result download folder
    |--------------------------------------------------------------------------
    |
    | Used by Open-Results-IE.bat to set Internet Explorer's default
    | download directory so files go to the lottery application folder.
    |
    */

    'download_folder' => env('LOTTERY_DOWNLOAD_FOLDER', 'C:\\infospare\\results'),

];
