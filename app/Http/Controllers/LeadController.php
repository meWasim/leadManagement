<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Branch;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::all();
        return view('leads.list', compact('leads'));
    }

    public function create()
    {
      $branc=Branch::select('id','name')->get();
      
        return view('leads.add',compact('branc'));
    }

    public function store(Request $request)
    {
        try {
            Lead::create([
                'Date' => $request->input('Date'),
                'Branch' => $request->input('Branch'),
                'ResourceID' => $request->input('ResourceID'),
                'CompanyName' => $request->input('CompanyName'),
                'ContactPerson' => $request->input('ContactPerson'),
                'MobileNumber' => $request->input('MobileNumber'),
                'MailId' => $request->input('MailId'),
                'Address' => $request->input('Address'),
                'PinCode' => $request->input('PinCode'),
                'Product' => $request->input('Product'),
                'Service' => $request->input('Service'),
                'NextFollowUpDate' => $request->input('NextFollowUpDate'),
                'Remarks' => $request->input('Remarks'),
                'user_id' => $request->input('user_id'),
            ]);
    
            return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    
        } catch (\Exception $e) {
            \Log::error('Error creating lead: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Error creating lead. Please try again.');
        }
    }
    
    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        return view('leads.show', compact('lead'));
    }

    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        return view('leads.edit', compact('lead'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Date' => 'nullable|date',
            'Branch' => 'nullable|string',
            'ResourceID' => 'nullable|string',
            'CompanyName' => 'nullable|string',
            'ContactPerson' => 'nullable|string',
            'MobileNumber' => 'nullable|string|max:15',
            'MailId' => 'nullable|string',
            'Address' => 'nullable|string',
            'PinCode' => 'nullable|string|max:10',
            'Product' => 'nullable|string',
            'Service' => 'nullable|string',
            'NextFollowUpDate' => 'nullable|date',
            'Remarks' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $lead = Lead::findOrFail($id);
        $lead->update($validatedData);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }
}
