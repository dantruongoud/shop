<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\MailNotify;
use App\Models\History;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {   
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $cart = [];
        $total = 0;
        $products = [];
        $qty = 0;

        if (session()->has('cart')) {
            $cart = session('cart');
            foreach ($cart as $item) {
                $productId = $item['id_product'];
                $product = Product::findOrFail($productId);
                
                $products[] = [
                    'product' => $product,
                    'qty' => $item['qty']
                ];
            }

            foreach ($products as $item) {
                $total += $item['product']->price * $item['qty'];
                $qty += $item['qty'];
            }
        }
        $data = [
            'subject' => 'Bill from E-Shopper',
            'total' => $total,
            'Product' => $products,
            'Quantity' => $qty,
            'phone' => $user->phone,
            'address' => $user->address,
            'name' => $user->name
        ];

        try {
            Mail::to($user->email)->send(new MailNotify($data, $total, $products, $qty, $user->phone, $user->name, $user->address));
            $history = [
                'email' => $user->email,
                'phone' => $user->phone,
                'name' => $user->name,
                'id_user' => $user->id,
                'price' => $total
            ];
            History::create($history);
            return response()->json(['Great check your mail box']);
        } catch (Exception $th) {
            dd($th);
            return response()->json(['Sorry, something went wrong']);
        }
    }
}
