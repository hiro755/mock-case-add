<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Mail\TransactionCompleted;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{
    public function show(Product $product)
    {
        $user = auth()->user();

        $isBuyer  = $user->id === $product->buyer_id;
        $isSeller = $user->id === $product->user_id;
        $otherUser = $isSeller ? $product->buyer : $product->user;

        $transactions = Product::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('buyer_id', $user->id);
        })
        ->where('is_completed', false)
        ->withCount([
            'messages as unread_count' => function ($query) use ($user) {
                $query->where('is_read', false)
                      ->where('user_id', '!=', $user->id);
            }
        ])
        ->orderByDesc('updated_at')
        ->get();

        $messages = $product->messages()
            ->with('user')
            ->orderBy('created_at')
            ->get();

        $product->messages()
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $hasRated = $isBuyer
            ? $product->rating_from_buyer !== null
            : $product->rating_from_seller !== null;

        if ($isSeller && $product->is_completed && $product->rating_from_seller === null) {
            session()->flash('show_rating_modal', true);
        }

        return view('chat.show', compact(
            'product',
            'otherUser',
            'transactions',
            'messages',
            'isBuyer',
            'isSeller',
            'hasRated'
        ));
    }

    public function store(MessageRequest $request, Product $product)
    {
        $validated = $request->validated();

        $message = new Message();
        $message->product_id = $product->id;
        $message->user_id = auth()->id();
        $message->body = $validated['body'];

        if ($request->hasFile('image')) {
            $message->image_path = $request->file('image')->store('chat_images', 'public');
        }

        $message->save();

        return redirect()->route('chat.show', $product->id);
    }

    public function edit(Product $product, Message $message)
    {
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }

        return redirect()
            ->route('chat.show', $product->id)
            ->with('edit_message_id', $message->id);
    }

    public function update(Request $request, Product $product, Message $message)
    {
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['body' => 'required|string|max:400']);
        $message->body = $request->body;
        $message->save();

        return redirect()->route('chat.show', $product->id);
    }

    public function destroy(Product $product, Message $message)
    {
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }

        $message->delete();
        return redirect()->route('chat.show', $product->id);
    }

    public function complete(Product $product)
    {
        $user = auth()->user();

        if ($user->id !== $product->buyer_id) {
            abort(403);
        }

        if ($product->is_completed) {
            return redirect()->route('chat.show', $product->id);
        }

        $product->is_completed = true;
        $product->save();

        Mail::to($product->user->email)->send(new TransactionCompleted($product));

        return redirect()
            ->route('chat.show', $product->id)
            ->with('show_rating_modal', true);
    }

    public function rate(Request $request, Product $product)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);

        $user = auth()->user();

        if ($user->id === $product->buyer_id) {
            $product->rating_from_buyer = $request->rating;
        } elseif ($user->id === $product->user_id) {
            $product->rating_from_seller = $request->rating;
        } else {
            abort(403);
        }

        $product->save();

        return redirect()->route('products.index')->with('status', '評価を送信しました');
    }
}