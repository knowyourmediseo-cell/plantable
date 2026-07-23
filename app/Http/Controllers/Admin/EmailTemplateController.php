<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::paginate(20);
        return view('admin.pages.email-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.pages.email-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:email_templates',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'variables' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        EmailTemplate::create($validated);

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template created successfully.');
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.pages.email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        // AJAX toggle status
        if ($request->expectsJson()) {
            $emailTemplate->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:email_templates,slug,' . $emailTemplate->id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'variables' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $emailTemplate->update($validated);

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template updated successfully.');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return redirect()->route('admin.email-templates.index')->with('success', 'Email template deleted successfully.');
    }
}
