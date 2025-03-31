use App\Http\Controllers\ProductController;
Route::post('/Product/updateCart', [ProductController::class, 'updateToCart']);
