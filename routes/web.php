<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});
Route::get('/test', function () {

    $haystack = 'hello';
    $needle = 'o';
    dd(strpos($haystack, $needle, strlen($haystack) - 1));
    dd($haystack[strlen($haystack) -1] === $needle);
    return $haystack[strlen($haystack) -1] === $needle;
    return \App\Http\Controllers\CustomerController::$heelo;
//    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
//    $chars = str_shuffle($chars);
//    dd(substr($chars, 0, 8));
    $type = 'numeric';
    $length = 20;

    $str = '';
    switch($type){
        case 'alpha_upper':
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 'alpha_lower':
            $chars = 'abcdefghijklmnopqrstuvwxyz';
            break;
        case 'numeric':
            $chars = '0123456789';
            break;
        case 'alpha_symbols':
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~';
            break;
        case 'alpha_numeric':
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            break;
        default:
             $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~';
            break;

    }
    $chars = str_shuffle($chars);
    for ($i = 0; $i < $length;  $i++){
        $str .= $chars[rand(0, strlen($chars) - 1)];
    }
    dd($str);

    // TODO Generate a string $length chars long from the selected charset


});
//Route::get('/{any}', 'HomeController@index')->where('any', '.*');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('newsletter/tracking/{id}', 'NewsletterRecipientController@track');
//Route::get('newsletter/unsubscribe/{id}');