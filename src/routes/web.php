<?php

// Index controller for SPA
Route::get('/{any?}', 'IndexController@index')->where('any', '^(?!api\/)[\/\w\.-]*')->name('index');