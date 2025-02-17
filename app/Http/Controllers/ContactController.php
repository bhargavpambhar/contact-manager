<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use SimpleXMLElement;
use Exception;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $contacts = Contact::all();
            return view('contacts.index', compact('contacts'));
        } catch (Exception $e) {
            return redirect()->route('contacts.index')->with('error', 'Failed to retrieve contacts: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:contacts,email',
                'phone_number' => 'required|unique:contacts,phone_number',
                'company_name' => 'nullable|string'
            ]);

            Contact::create($validated);

            return redirect()->route('contacts.index')->with('success', 'Contact added successfully');
        } catch (Exception $e) {
            return redirect()->route('contacts.create')->with('error', 'Failed to add contact: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            return view('contacts.show', compact('contact'));
        } catch (Exception $e) {
            return redirect()->route('contacts.index')->with('error', 'Failed to retrieve contact: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            return view('contacts.edit', compact('contact'));
        } catch (Exception $e) {
            return redirect()->route('contacts.index')->with('error', 'Failed to retrieve contact for editing: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $contact = Contact::findOrFail($id);

            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:contacts,email,' . $contact->id,
                'phone_number' => 'required|unique:contacts,phone_number,' . $contact->id,
                'company_name' => 'nullable|string'
            ]);

            $contact->update($validated);

            return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
        } catch (Exception $e) {
            return redirect()->route('contacts.edit', ['id' => $id])->with('error', 'Failed to update contact: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Contact::findOrFail($id)->delete();
            return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('contacts.index')->with('error', 'Failed to delete contact: ' . $e->getMessage());
        }
    }

    public function importXML(Request $request)
    {
        try {
            $request->validate([
                'xml_file' => 'required|mimes:xml|max:10240'
            ]);

            // Read the file content
            $xmlContent = file_get_contents($request->file('xml_file'));
            $xml = new SimpleXMLElement($xmlContent);

            // Chunk-wise data insertion
            $chunkSize = 1000;
            $contactsData = [];

            foreach ($xml->contact as $c) {
                // Check if contact with the same email or phone number already exists
                $existingContact = Contact::where('email', (string) $c->email)
                                        ->orWhere('phone_number', (string) $c->phone_number)
                                        ->first();

                // If no existing contact found, add it to the insert array
                if (!$existingContact) {
                    $contactsData[] = [
                        'first_name' => (string) $c->first_name,
                        'last_name' => (string) $c->last_name,
                        'email' => (string) $c->email,
                        'phone_number' => (string) $c->phone_number,
                        'company_name' => (string) $c->company_name
                    ];
                }

                // Insert in chunks
                if (count($contactsData) >= $chunkSize) {
                    Contact::insert($contactsData);
                    $contactsData = [];
                }
            }

            // Insert any remaining data that wasn't inserted yet
            if (count($contactsData) > 0) {
                Contact::insert($contactsData);
            }

            return redirect()->route('contacts.index')->with('success', 'Contacts imported successfully');
        } catch (Exception $e) {
            return redirect()->route('contacts.index')->with('error', 'Failed to import contacts: ' . $e->getMessage());
        }
    }


}
