<?php

Route::middleware(['web', 'admin'])
->any(
    'admin/visualcomposer-file-upload',
    'Bozboz\LaravelBackpackVisualcomposer\Http\Controllers\FileUploadController@upload'
)->name('visualcomposer.fileupload');
