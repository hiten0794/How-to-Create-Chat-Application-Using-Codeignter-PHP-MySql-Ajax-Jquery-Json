<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'PagesController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['admin-login'] = 'PagesController/index';
$route['dashboard-login'] = 'UserController/userlogin';
$route['dashboard-register'] = 'UserController/register_user';
$route['logout'] = 'UserController/logout';
 $route['v3/dashboard'] = 'DashboardController/index';
$route['v3/profile'] = 'ProfileController/index';
$route['upload-profile'] = 'ProfileController/change_photo';
$route['profile-password-update'] = 'ProfileController/change_user_profile_password_update';
$route['profile-details-update'] = 'ProfileController/user_update_profile_data';
$route['i-forgot-my-password'] = 'ProfileController/forgot_password';
$route['forgot-password'] = 'ProfileController/forgot_password_email';
$route['all-messages'] = 'MessagesController/index';
$route['view-all-notifications'] = 'NotificationsController/index';
$route['vendor/list'] = 'VendorController/template';
$route['vendor/grid-data'] = 'VendorController/grid_data';
$route['vendor/trash'] = 'VendorController/trash';
$route['vendor/status'] = 'VendorController/status';
$route['vendor/block'] = 'VendorController/block';
$route['vendor'] = 'VendorController/register_template';
$route['vendor-register-api'] = 'VendorController/register_api';
$route['customer/list'] = 'CustomerController/template';
$route['customer/grid-data'] = 'CustomerController/grid_data';
$route['customer/trash'] = 'CustomerController/trash';
$route['customer/status'] = 'CustomerController/status';
$route['categories'] = 'CategoryController/index';
$route['add-category'] = 'CategoryController/add_category';
$route['category-grid-data'] = 'CategoryController/category_grid_data';
$route['category_view'] = 'CategoryController/category_view';
$route['edit_category'] = 'CategoryController/edit_category';
$route['trash-category'] = 'CategoryController/category_trash';
$route['category/block'] = 'CategoryController/block';
 
$route['add-product'] = 'ProductController/index';
$route['edit-product/:any'] = 'ProductController/edit_product';
$route['all-products'] = 'ProductController/list_template';
$route['products/grid-data'] = 'ProductController/grid_data';
$route['childCategory'] = 'ProductController/childCategory';
$route['add-product-api'] = 'ProductController/add_product_api';
$route['product/trash'] = 'ProductController/trash';
$route['galleryimagesremove'] = 'ProductController/galleryimagesremove';
$route['update_product_api'] = 'ProductController/update_product_api';
$route['product/block'] = 'ProductController/block';
$route['product-analysis/:any'] = 'ProductController/product_analysis';
$route['remove-review-on-product'] = 'ProductController/trash_product_review';
$route['discount-coupon'] = 'CouponController/index';
$route['add_coupon_api'] = 'CouponController/add_coupon_api';
$route['coupon_grid_data'] = 'CouponController/coupon_grid_data';
$route['coupon_trash'] = 'CouponController/coupon_trash';
$route['edit-coupon'] = 'CouponController/edit_coupon_api_data';
$route['edit_coupon_api'] = 'CouponController/edit_coupon_api';
$route['orders'] = 'OrdersController/index';
$route['orders/grid_data'] = 'OrdersController/grid_data';
$route['order-view/:any'] = 'OrdersController/single_order_view';
$route['order/update-status'] = 'OrdersController/update_order_status';
$route['order/trash-admin'] = 'OrdersController/trash';
$route['admin-full-invoice'] = 'InvoiceController/index';
$route['print-invoice/:any'] = 'InvoiceController/print_invoice';
////////////////
$route['chat'] = 's/ChatController/index';
$route['send-message'] = 's/ChatController/send_text_message';
$route['chat-attachment/upload'] = 's/ChatController/send_text_message';
$route['get-chat-history-vendor'] = 's/ChatController/get_chat_history_by_vendor';
$route['chat-clear'] = 's/ChatController/chat_clear_client_cs';
$route['blog'] = 's/BlogController/index';
$route['post-a-blog/:any'] = 's/BlogController/post_a_blog';
$route['edit-blog/:any'] = 's/BlogController/edit_a_blog';
$route['update-blog'] = 's/BlogController/update_blog';
$route['delete-blog/:any'] = 's/BlogController/trash_blog';
$route['blog-post'] = 's/BlogController/add_new_blog';
/////////Frontend////////////////////////
$route['user-register'] = 'CustomerController/register';
$route['webuser-login'] = 'CustomerController/webuserlogin';
$route['log-out'] = 'CustomerController/webuserlogout';
$route['front/slider'] = 'SliderController/index';
$route['add-slide'] = 'SliderController/add_new_slide';
$route['slider-grid-data'] = 'SliderController/slide_grid_data';
$route['slide_view'] = 'SliderController/slide_view';
$route['edit_slide'] = 'SliderController/edit_slide';
$route['trash-slide'] = 'SliderController/slide_trash';
$route['slide/status'] = 'SliderController/status';
$route['front/brand'] = 'BrandsController/index';
$route['add-brand'] = 'BrandsController/add_new_slide';
$route['brand-grid-data'] = 'BrandsController/slide_grid_data';
$route['brand_view'] = 'BrandsController/slide_view';
$route['edit_brand'] = 'BrandsController/edit_slide';
$route['trash-brand'] = 'BrandsController/slide_trash';
$route['brand/status'] = 'BrandsController/status';
$route['my-account'] = 'v/MyAccountController/index';
$route['upload-photo'] = 'v/MyAccountController/change_photo';
$route['update-profile-details'] = 'v/MyAccountController/user_update_profile_data';

$route['product-brand'] = 'ProductBrandsController/index'; 
$route['add-product-brand'] = 'ProductBrandsController/add_new_brand';
$route['brand-product-grid-data'] = 'ProductBrandsController/brand_grid_data';
$route['brand_product_view'] = 'ProductBrandsController/brand_view';
$route['edit_product_brand'] = 'ProductBrandsController/edit_brand';
$route['trash-product-brand'] = 'ProductBrandsController/brand_trash';
$route['brand-product/status'] = 'ProductBrandsController/status';
$route['category-brands'] = 'ProductBrandsController/category_brands';
 
  
$route['my-wishlist'] = 'v/WishlistController/index';
$route['add-to-wishlist'] = 'v/WishlistController/addtowishlist';
$route['wishlist/removeItem'] = 'v/WishlistController/removeItem';
$route['single-product/:any'] = 'v/SinglePageController/index';
$route['similar-products/:any/:any'] = 'v/SinglePageController/similar_products';
$route['user-submit-review'] = 'v/ReviewController/sumbit_user_reivew_index';
 
$route['shop'] = 'v/ShopPageController/index';
$route['shop/(:any)'] = 'v/ShopPageController/index';
$route['shop/(:any)/(:any)'] = 'v/ShopPageController/index';
$route['ajax-single-product-view'] = 'v/ShopPageController/produtmodal';
$route['search'] = 'v/ShopPageController/index'; 
$route['product-fillter'] = 'v/ShopPageController/product_fillter'; 
$route['add-to-compare'] = 'v/CompareProductController/index';
$route['compare-products'] = 'v/CompareProductController/compare_products';
$route['compare-product-remove/(:any)'] = 'v/CompareProductController/product_remove';
$route['ajax-search'] = 'v/SearchController/index'; 
//////Cart
$route['add-to-cart'] = 'v/CartController/index';
$route['my-cart'] = 'v/CartController/my_cart';
$route['my-category'] = 'v/CartController/category';
$route['update-cart'] = 'v/CartController/update_cart';
$route['remove-cart-item'] = 'v/CartController/removecartItem';
$route['add-to-cart-product'] = 'v/CartController/add_to_cart_product';
$route['checkout'] = 'v/CheckoutController/index';
$route['proceed-to-order'] = 'v/ProductOrderController/index';
$route['my-orders'] = 'v/TrackOrderController/index';
$route['my-order-view/:any'] = 'v/TrackOrderController/order_view';
