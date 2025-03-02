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
        $tel = $request->tel_part1 . $request->tel_part2 .$request->tel_part3;

        $contact = $request->only([
            'first_name',
            'last_name',
            'gender',
            'email',
            'address',
            'building',
            'category_id',
            'detail'
        ]);

        $contact['tel'] = $tel;

        //genderの値を数値に変換
        $contact['gender'] = $contact['gender'] == '男性' ? 1 : ($contact['gender'] == '女性' ? 2 : 3);

        // カテゴリデータを取得します
        $categories = Category::all();

        // category_id に基づいて category を設定
        $contact['category'] = Category::find($contact['category_id'])->content;

        return view('contact.confirm', compact('contact', 'categories'));
    }
    public function thanks(Request $request)
    {
        $tel = $request->tel_part1 . $request->tel_part2 . $request->tel_part3;

        $contact['tel'] = $tel;

        $contact = $request->only([
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail']);

        Contact::create($contact);
        return view('contact.thanks');
    }
}