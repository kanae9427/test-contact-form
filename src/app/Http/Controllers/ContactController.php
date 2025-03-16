<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    public function index()
    {
        // カテゴリデータを取得します
        $categories = Category::all();
        // contact.indexビューにカテゴリデータを渡します
        return view('contact.index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contacts = $request->all();
        $category = Category::find($request->category_id);
        return view('contact.confirm', compact('contacts', 'category'));
    }

    public function thanks(Request $request)
    {
        if ($request->has('back')) {
            return redirect('/')->withInput();
        }

        $request['tel'] = $request->tel_1 . $request->tel_2 . $request->tel_3;
        Contact::create(
            $request->only([
                'category_id',
                'first_name',
                'last_name',
                'gender',
                'email',
                'tel',
                'address',
                'building',
                'detail'
            ])
        );
        return view('contact.thanks');
    }
}