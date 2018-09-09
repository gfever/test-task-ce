<?php
/**
 * @author d.ivaschenko
 */

return [
    'GET@/api/clean' => 'PrizeController@index',
    'GET@/api/clean/random' => 'PrizeController@random',
    'PUT@/api/clean/status' => 'PrizeController@status',
];