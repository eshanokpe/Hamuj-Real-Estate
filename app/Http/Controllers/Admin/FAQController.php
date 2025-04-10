<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faqs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Http;

class FAQController extends Controller
{
    public function index(){
        return view('admin.home.faq.index');
    }

    public function create(){
        return view('admin.home.faq.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        Faqs::create($validated);
        return redirect()->route('admin.faq.create')->with('success', 'FAQ created successfully.');
    }

    public function edit($id)
    {
        $faq = Faqs::findOrFail(decrypt($id));
        return view('admin.home.faq.edit', compact('faq'));
    }
 
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
    
        // Find the service record by ID
        $faqs = Faqs::findOrFail($id);    
        $faqs->update($validated);
    
        return redirect()->route('admin.faq.index')->with('success', 'Faqs updated successfully.');
    }
    
    public function destroy($id)
    {
        $faqs= Faqs::findOrFail(decrypt($id));
        $faqs->delete();
        return redirect()->route('admin.faq.index')->with('success', 'Faqs deleted successfully.');
    }


}
