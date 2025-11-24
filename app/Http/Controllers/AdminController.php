<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Messages;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

// use App\Models\Banner;

class AdminController extends Controller
{
    // view all products
    public function product() {
        $products = Product::all();
        return view('admin.product', compact('products'));
    }
    // get create new product
    public function createProduct() {
        return view('admin.create-product');
    }
    // post create new product
    public function createProductPost(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $image = $image_name;
        }
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->image = $image;
        $product->save();
        return redirect()->back()->with('success', 'Product created successfully');
    }

    // get update product
    public function updateProduct($id) {
        $product = Product::find($id);
        return view('admin.update-product', compact('product'));
    }
    // post update product
    public function updateProductPost($id,Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $image = $image_name;
        }
        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $image,
        ]);
        return redirect()->back()->with('success', 'Product updated successfully');
    }
    // delete product
    public function deleteProduct($id) {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');
    }

    // view all users
    public function user() {
        $users = User::all();
        return view('admin.user', compact('users'));
    }
    // get create new user
    public function createUser() {
        return view('admin.create-user');
    }
    // post create new user
    public function createUserPost(Request $request) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
        return redirect()->back()->with('success', 'User created successfully');
    }
    // update user
    public function updateUser($id) {
        $user = User::find($id);
        return view('admin.update-user', compact('user'));
    }
    // post update user
    public function updateUserPost($id,Request $request) {
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect()->back()->with('success', 'User updated successfully');
    }
    // delete user
    public function deleteUser($id) {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
    // View single user cart
    public function userCart($id) {
        $user = User::find($id);
        return view('admin.user-cart', compact('user'));
    }
    

    // view all messages
    public function message() {
        $messages = Messages::all();
        return view('admin.message', compact('messages'));
    }
    // get reply to message
    public function replyMessage($id) {
        $message = Messages::find($id);
        return view('admin.reply-message', compact('message'));
    }
    // post reply to message
    public function replyMessagePost($id,Request $request) {
        $message = Messages::find($id);
        $message->update([
            'reply' => $request->reply,
        ]);
        return redirect()->back()->with('success', 'Message replied successfully');
    }
    // delete message
    public function deleteMessage($id) {
        $message = Messages::find($id);
        $message->delete();
        return redirect()->back()->with('success', 'Message deleted successfully');
    }

    // view all news
    public function news() {
        $news = News::all();
        return view('admin.news', compact('news'));
    }
    // get create new news
    public function createNews() {
        return view('admin.create-news');
    }
    // post create new news
    public function createNewsPost(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $news = new News();
        $news->title = $request->title;
        $news->description = $request->description;
        // save image to public folder
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $image_name);
        $news->image = $image_name;


        $news->save();
        return redirect()->back()->with('success', 'News created successfully');
    }
    // update news
    public function updateNews($id) {
        $news = News::find($id);
        return view('admin.update-news', compact('news'));
    }
    // post update news
    public function updateNewsPost($id,Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $news = News::find($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $image = $image_name;
        }
        $news->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $image,
        ]);
        return redirect()->back()->with('success', 'News updated successfully');
    }
    // delete news
    public function deleteNews($id) {
        $news = News::find($id);
        $news->delete();
        return redirect()->back()->with('success', 'News deleted successfully');
    }

    // view all banners
    // public function banner() {
    //     $banners = Banner::all();
    //     return view('admin.banner', compact('banners'));
    // }
    // // create new banner
    // public function createBanner() {
    //     return view('admin.create-banner');
    // }
    // // update banner
    // public function updateBanner($id) {
    //     $banner = Banner::find($id);
    //     return view('admin.update-banner', compact('banner'));
    // }
    // // delete banner
    // public function deleteBanner($id) {
    //     $banner = Banner::find($id);
    //     $banner->delete();
    //     return redirect()->back()->with('success', 'Banner deleted successfully');
    // }

    // portal
    public function login() {
        return view('admin.login');
    }
    public function loginPost(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->role == 'admin') {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    return redirect()->route('admin.dashboard');
                }
            }
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }
    public function logout() {
        Auth::logout();
        return redirect()->route('admin.login');
    }
        
}
