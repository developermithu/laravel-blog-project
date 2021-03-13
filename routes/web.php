<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentControllerAdmin;
use App\Http\Controllers\Admin\CommentReplyControllerAdmin;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\User\CommentControllerUser;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\CommentReplyControllerUser;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Middleware\AdminAccess;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPost;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Laravel\Socialite\Facades\Socialite;


Auth::routes();

//========= Route for Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//========== Route for Email Verification

//========== Route for Social Login
Route::get('/login/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/login/google/callback', function () {
    $user = Socialite::driver('google')->user();

    $authUser = User::where('email', $user->email)->first();
    if ($authUser) {
        Auth::login($authUser);
        return redirect()->route('home');
    } else {
        $newUser = new User();
        $newUser->name = $user->name;
        $newUser->userid = $user->id;
        $newUser->email = $user->email;
        $newUser->email_verified_at = Date::now(); //timestamp for auto verification
        $newUser->password = uniqid(); //we don''t need pwd
        $newUser->save();
        Auth::login($newUser);
        return redirect()->route('home');
    }
});
//========== Route for Social Login


// view composer for sidebar
// view::composer dile view include kora lagbe
view()->composer('layouts.frontend.partials.sidebar', function ($view) {
    $categories = Category::all()->take(6);
    $recentTags = Tag::all();
    $recentPosts = Post::latest()->take(3)->get();
    return $view->with('categories', $categories)->with('recentPosts', $recentPosts)->with('recentTags', $recentTags);
});


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('posts', [HomeController::class, 'posts'])->name('posts');
Route::get('post/{slug}', [HomeController::class, 'post'])->name('post');
Route::get('categories', [HomeController::class, 'categories'])->name('categories');
Route::get('category/{slug}', [HomeController::class, 'postByCategory'])->name('category.post');
Route::get('tag/{name}', [HomeController::class, 'postByTag'])->name('tag.post');
Route::get('search', [HomeController::class, 'search'])->name('search'); //search
Route::post('comment/{post}', [CommentController::class, 'store'])->name('comment.store')->middleware('auth', 'verified');
Route::post('comment-reply/{comment}', [CommentReplyController::class, 'store'])->name('reply.store')->middleware('auth', 'verified');
Route::post('like-post/{post}', [HomeController::class, 'likePost'])->name('like.post');

//================================== Admin ==========================//
//==================================================================//
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin', 'verified']], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'showProfile'])->name('profile');
    Route::put('profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [DashboardController::class, 'changePassword'])->name('profile.password');
    Route::get('comments', [CommentControllerAdmin::class, 'index'])->name('comment');
    Route::delete('comment/{id}', [CommentControllerAdmin::class, 'destroy'])->name('comment.destroy');
    Route::get('comment-replies', [CommentReplyControllerAdmin::class, 'index'])->name('comment-reply');
    Route::delete('comment-reply/{id}', [CommentReplyControllerAdmin::class, 'destroy'])->name('comment-reply.destroy');

    // Route::resource('user', UserController::class); or

    //UserController 
    Route::get('user', [UserController::class, 'index'])->name('user');  //admin.user
    Route::put('user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    //CategoryController 
    Route::get('category', [CategoryController::class, 'index'])->name('category');
    Route::post('category/create', [CategoryController::class, 'store'])->name('category.store');
    Route::put('category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    //PostController 
    Route::get('post', [PostController::class, 'index'])->name('post');
    Route::get('post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('post/create', [PostController::class, 'store'])->name('post.store');
    Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');
    Route::get('post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('post/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('post/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('post-like-user/{id}', [PostController::class, 'likedUser'])->name('post.like.user');
});


//================================== User ==========================//
//================================================================//
Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User', 'middleware' => ['auth', 'user', 'verified']], function () {
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('comments', [CommentControllerUser::class, 'index'])->name('comment');
    Route::delete('comment/{id}', [CommentControllerUser::class, 'destroy'])->name('comment.destroy');
    Route::get('my-replies', [CommentReplyControllerUser::class, 'index'])->name('comment-reply');
    Route::delete('my-replies/{id}', [CommentReplyControllerUser::class, 'destroy'])->name('comment-reply.destroy');
    // Author Profile
    Route::get('profile', [UserDashboardController::class, 'showProfile'])->name('profile');
    Route::put('profile/update', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [UserDashboardController::class, 'changePassword'])->name('profile.password');
});

// For Mail sending
Route::get('send', function () {
    $post = Post::findOrFail(7);
    Mail::to('user@gmail.com')
        ->bcc(['user2@gmail.com', 'user3@gmail.com'])
        ->queue(new NewPost($post));  //queue instead send
    return new NewPost($post);  //->render()
});
