<?php

// Route::get('/', [LaraChan\Core\Http\Controllers\HomepageController::class, 'homepage']); // See: routes/web.php

Route::get('/{board}', [LaraChan\Core\Http\Controllers\BoardController::class, 'index']);

Route::get('/{board}/new-thread', [LaraChan\Core\Http\Controllers\ThreadController::class, 'newThread'])
    ->name('newThread')
    ->middleware(['web']);

Route::post('{board}/new-thread', [LaraChan\Core\Http\Controllers\ThreadController::class, 'create']);

Route::get('/{board}/{threadID}',  [LaraChan\Core\Http\Controllers\ThreadController::class, 'single'])
    ->name('singleThread')
    ->middleware(['web']);

Route::post('/{board}/{threadID}', [LaraChan\Core\Http\Controllers\ThreadController::class, 'reply']);

