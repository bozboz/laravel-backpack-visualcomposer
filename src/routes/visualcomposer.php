<?php

Route::middleware(['web', 'admin'])
->any(
    'admin/visualcomposer-file-upload',
    'Bozboz\Backpack\VisualComposer\Http\Controllers\FileUploadController@upload'
)->name('visualcomposer.fileupload');
