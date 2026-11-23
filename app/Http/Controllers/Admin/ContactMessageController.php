<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.contact-messages.index', compact('messages'));
    }

    public function update(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,replied,archived',
            'admin_note' => 'nullable|string',
        ]);
        $validated['handled_by'] = auth()->id();
        $validated['handled_at'] = now();
        $contactMessage->update($validated);
        return back()->with('success', 'Pesan berhasil diperbarui.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
