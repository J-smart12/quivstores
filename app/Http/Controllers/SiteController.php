<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Settings;
use App\Models\News;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index() {
        $categories = Category::all();
        $products = Product::all();
        $settings = Settings::all();
        return view('index', compact('categories', 'products', 'settings'));
    }

    public function contactus() {
        $settings = Settings::all();
        return view('contactus', compact('settings'));
    }

    public function aboutus() {
        $settings = Settings::all();
        return view('aboutus', compact('settings'));
    }

    public function notfound() {
        $settings = Settings::all();
        return view('404', compact('settings'));
    }

    // post search
    public function searchpost(Request $request) {
        $products = Product::where('name', 'like', "%{$request->search}%")->get();
        $settings = Settings::all();
        return view('search', compact('settings', 'products'));
    }

    public function login() {
        $settings = Settings::all();
        return view('login', compact('settings'));
    }

    public function register() {
        $settings = Settings::all();
        return view('sign-up', compact('settings'));
    }


    public function faq() {
        $settings = Settings::all();
        return view('faq', compact('settings'));
    }

    public function shop() {
        $categories = Category::all();
        $products = Product::all();
        $settings = Settings::all();
        return view('shop-grid', compact('settings', 'categories', 'products'));
    }

    public function productDetail($id) {
        $product = Product::find($id);
        $settings = Settings::all();
        return view('product-details', compact('settings', 'product'));
    }

    // News paginated
    public function news() {
        $settings = Settings::all();
        $news = News::paginate(10);
        return view('news-grid', compact('settings', 'news'));
    }

    // News detail
    public function newsDetail($id) {
        $news = News::find($id);
        $settings = Settings::all();
        return view('news-details', compact('settings', 'news'));
    }

}
