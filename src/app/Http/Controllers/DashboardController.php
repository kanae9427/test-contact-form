<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin(Request $request)
    {
        $categories = Category::all();
        $keyword = $request->input('keyword');

        if ($request->filled('keyword')) {
            // 完全一致検索
            $contacts = Contact::where('first_name', $keyword)
                ->orWhere('last_name', $keyword)
                ->orWhere('email', $keyword)
                ->orWhere('gender', $keyword)
                ->orWhere('category_id', $keyword)
                ->orWhere('created_at', $keyword)
                ->get();

            // 完全一致の結果が空の場合、部分一致検索を実行
            if ($contacts->isEmpty()) {
                $contacts = Contact::where('first_name', 'LIKE', "%$keyword%")
                    ->orWhere('last_name', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%")
                    ->orWhere('gender', 'LIKE', "%$keyword%")
                    ->orWhere('category_id', 'LIKE', "%$keyword%")
                    ->orWhere('created_at', 'LIKE', "%$keyword%")
                    ->get();
            }
        } else {
            // キーワードが入力されていない場合、全件取得
            $contacts = Contact::query();
            $contacts = $contacts->paginate(7);
        }

        return view('admin.dashboard', compact('contacts', 'categories'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('/admin')->with('success', 'お問い合わせが削除されました');
    }
}
