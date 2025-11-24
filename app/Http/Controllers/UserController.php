<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function dashboard() {
        return view('my-account');
    }

    public function cart() {
        return view('shop-cart');
    }

    public function AddToCart(Request $request) {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::find($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function RemoveFromCart(Request $request) {
        $request->validate([
            'product_id' => 'required',
        ]);

        $product = Product::find($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product removed from cart successfully');
    }

    public function wishlist() {
        return view('wishlist');
    }

    public function message() {
        return view('message');
    }

    public function updateInformation(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'string',
            'zip' => 'string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $image = $image_name;
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city??'';
        $user->zip = $request->zip??'';
        $user->image = $image;
        $user->save();

        return redirect()->back()->with('success', 'Information updated successfully');
    }

    public function ChangePassword(Request $request) {
        $request->validate([
            'password' => 'required | min:8 | max:12 | confirmed',            
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('index');
    }

    public function registerPost(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required | min:8 | max:12 | confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Information updated successfully');
    }

    public function loginPost(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function forgotPassword() {
        return view('forgot-password');
    }

    
    public function forgotPasswordPost(Request $request) {
        $request->validate([
            'email' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            // send reset email code
            $code = rand(10000, 99999);
            $user->reset_code = $code;
            $user->save();

            // send email
            Mail::to($user->email)->send(new ResetPasswordMail($user));

            return redirect()->route('login')->with('success', 'Password reset successfully');
        }

        return redirect()->back()->with('error', 'Invalid email');
    }

    public function resetPassword() {
        return view('reset-password');
    }

    public function resetPasswordPost(Request $request) {
        $request->validate([
            'email' => 'required',
            'code' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->reset_code == $request->code) {
                $user->password = bcrypt($request->password);
                $user->reset_code = null;
                $user->save();
                return redirect()->route('login')->with('success', 'Password reset successfully');
            }
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

}
