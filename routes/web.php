<?php

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', "homeController@home");
Route::get("/category/{name}/{id}","homeController@subCategory");
Route::get("/shop","homeController@shop");
Route::get("/shop/{category}/{id}","homeController@shopSubCategory");

Route::group(['middleware' => 'auth',
			  'prefix'     => 'customer',
              'namespace'  => 'customer'
], function () {
Route::get("/dashboard","dashboardController@customerDashboard");
Route::get("/past-orders","dashboardController@pastOrders");
Route::get("/logout","dashboardController@logout");
});
// Route::get();
Route::get('/contact', function () {
    return view('contact');
});

//cart design
Route::get("/cart","cartController@cart");
Route::post("/add-to-cart/{id}","cartController@addToCart");
Route::post("/remove-from-cart/{id}","cartController@removeFromCart");
Route::post("/update-cart","cartController@updateCart");
Route::get("/checkout","cartController@checkout");
Route::post("/checkout","cartController@order");

Route::get('/welcome2', function () {
    return view('welcome2');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/shopingcart', function () {
    return view('pages.shopingcart');
});
Route::get('/shopdetails', function () {
    return view('pages.shopdetails');
});
// Route::get('/checkout', function () {
//     return view('pages.checkout');
// });
Route::get('/blogdetails', function () {
    return view('pages.blogdetails');
});

// Admin Interface
Route::group(['middleware' => 'admin',
			  'prefix'     => 'admin',
              'namespace'  => 'Admin'
], function () {

	CRUD::resource('categories', 'CategoryCrudController');
	CRUD::resource('currencies', 'CurrencyCrudController');
	CRUD::resource('carriers', 'CarrierCrudController');
	CRUD::resource('attributes', 'AttributeCrudController');
	CRUD::resource('attributes-sets', 'AttributeSetCrudController');
	CRUD::resource('products', 'ProductCrudController');
	CRUD::resource('taxes', 'TaxCrudController');
	CRUD::resource('orders', 'OrderCrudController');
	CRUD::resource('order-statuses', 'OrderStatusCrudController');
	CRUD::resource('clients', 'ClientCrudController');
	CRUD::resource('users', 'UserCrudController');
	CRUD::resource('cart-rules', 'CartRuleCrudController');
	CRUD::resource('specific-prices', 'SpecificPriceCrudController');
	CRUD::resource('notification-templates', 'NotificationTemplateCrudController');

	// Clone Products
	Route::post('products/clone', ['as' => 'clone.product', 'uses' => 'ProductCrudController@cloneProduct']);

	// Update Order Status
	Route::post('orders/update-status', ['as' => 'updateOrderStatus', 'uses' => 'OrderCrudController@updateStatus']);
});


// Ajax
Route::group(['middleware' => 'admin',
			  'prefix' => 'ajax',
			  'namespace' => 'Admin'
], function() {
	// Get attributes by set id
	Route::post('attribute-sets/list-attributes', ['as' => 'getAttrBySetId', 'uses' => 'AttributeSetCrudController@ajaxGetAttributesBySetId']);

	// Product images upload routes
	Route::post('product/image/upload', ['as' => 'uploadProductImages', 'uses' => 'ProductCrudController@ajaxUploadProductImages']);
	Route::post('product/image/reorder', ['as' => 'reorderProductImages', 'uses' => 'ProductCrudController@ajaxReorderProductImages']);
	Route::post('product/image/delete', ['as' => 'deleteProductImage', 'uses' => 'ProductCrudController@ajaxDeleteProductImage']);

	// Get group products by group id
	Route::post('product-group/list/products', ['as' => 'getGroupProducts', 'uses' => 'ProductGroupController@getGroupProducts']);
	Route::post('product-group/list/ungrouped-products', ['as' => 'getUngroupedProducts', 'uses' => 'ProductGroupController@getUngroupedProducts']);
	Route::post('product-group/add/product', ['as' => 'addProductToGroup', 'uses' => 'ProductGroupController@addProductToGroup']);
	Route::post('product-group/remove/product', ['as' => 'removeProductFromGroup', 'uses' => 'ProductGroupController@removeProductFromGroup']);

	// Client address
	Route::post('client/list/addresses', ['as' => 'getClientAddresses', 'uses' => 'ClientAddressController@getClientAddresses']);
	Route::post('client/add/address', ['as' => 'addClientAddress', 'uses' => 'ClientAddressController@addClientAddress']);
	Route::post('client/delete/address', ['as' => 'deleteClientAddress', 'uses' => 'ClientAddressController@deleteClientAddress']);

	// Client company
	Route::post('client/list/companies', ['as' => 'getClientCompanies', 'uses' => 'ClientCompanyController@getClientCompanies']);
	Route::post('client/add/company', ['as' => 'addClientCompany', 'uses' => 'ClientCompanyController@addClientCompany']);
	Route::post('client/delete/company', ['as' => 'deleteClientCompany', 'uses' => 'ClientCompanyController@deleteClientCompany']);

	// Notification templates
	Route::post('notification-templates/list-model-variables', ['as' => 'listModelVars', 'uses' => 'NotificationTemplateCrudController@listModelVars']);
});
