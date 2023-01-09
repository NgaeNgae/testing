<?php
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
Route::post('/', function (Request $request) {
    $filename = time()."_".$request->file('image')->getClientOriginalName();

    Storage::putFileAs(
        'image',
        $request->file('image'),
        $filename,
    );

    Photo::create([
        'image' => $filename
    ]);
    return "Success";
})->name('save');

Route::get('/photo-delete', function () {
    $file = Photo::where('id',2)->first()->image;

    $path = storage_path('app/image/'.$file);
    // return $path;
     unlink($path);

     Photo::where('id', 2)->delete();

     return "Successful Deleted";
});

Route::get('/customer', function() {
    // foreach (range(1,15) as $value) {
    //     $faker = Faker\Factory::create();

    //     Customer::create([
    //         'name' =>$faker->name(),
    //         'email' =>$faker->email(),
    //         'password' => Hash::make($faker->password()),
    //     ]);

    // }

    return Customer::all();
});

Route::get('/product', function () {
    // Product::create([
    //     'name' => 'Sandwish',
    //     'price' => '3'
    // ]);

    return Product::all();
});

Route::get('/cart', function () {
    // Cart::create([
    //     'customer_id'=> 3,
    //     'product_id' => 1,
    //     'quantity' => 10
    // ]);
    return Customer::where('id', 3)->first()->carts;
});
