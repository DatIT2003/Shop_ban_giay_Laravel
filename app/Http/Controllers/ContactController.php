<?php

namespace App\Http\Controllers;

use App\Mail\ReplyMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    public function contact()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('status', '0')->orderBy('id', 'desc')->get();

        $contacts = Contact::orderBy('created_at', 'desc')->get();

        return view('pages.contact.contact')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('contacts', $contacts);
    }

    public function submitContactForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required',
        ]);

        Contact::create([
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Comment của bạn đã gửi thành công!!');
    }

    public function listContacts()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.contact-list')->with('contacts', $contacts);
    }

    public function showReplyForm($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contact-reply', compact('contact'));
    }

    public function sendReply(Request $request, $id)
{
    $request->validate([
        'reply' => 'required',
    ]);

    $contact = Contact::findOrFail($id);
    $reply = $request->input('reply');

    // Gửi email phản hồi
    Mail::to($contact->email)->send(new ReplyMail($reply, $contact));

    // Cập nhật trạng thái
    $contact->status = 'đã phản hồi';
    $contact->save();

    return redirect::to('contact-list')->with('message', 'Gửi phản hồi thành công !!!');
}
}
