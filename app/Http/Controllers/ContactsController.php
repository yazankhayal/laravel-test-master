<?php

namespace App\Http\Controllers;

use App\Company;
use App\Contact;
use App\ContactAddress;
use App\ContactRole;
use App\Http\Requests\CreateContact;
use App\Http\Requests\UpdateContact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(5);

        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        $contact = new Contact;
        $companies = Company::pluck('name', 'id');
        $contactRoles = ContactRole::pluck('name', 'id');

        return view('contacts.create', compact('contact', 'companies', 'contactRoles'));
    }

    public function store(CreateContact $request)
    {

        $get_id = Contact::create($request->all());

        $post_code = $request->post_code;

        if($post_code != null){
            if(count($post_code) != 0){
                foreach ($post_code as $key => $value){
                    if($value){
                        $save = new ContactAddress();
                        $save->post_code = $value;
                        $save->contacts_id = $get_id->id;
                        $save->save();
                    }
                }
            }
        }

        return redirect('contacts')->with('alert', 'Contact created!');
    }

    public function edit(Contact $contact)
    {
        $companies = Company::pluck('name', 'id');
        $contactRoles = ContactRole::pluck('name', 'id');

        return view('contacts.edit', compact('contact', 'companies', 'contactRoles'));
    }

    public function update(UpdateContact $request, Contact $contact)
    {
        $contact->update($request->all());

        $post_code = $request->post_code;

        if($post_code != null){
            if(count($post_code) != 0){
                foreach ($post_code as $key => $value){
                    if($value){
                        $edit = ContactAddress::where([
                            'post_code' => $value,
                            'contacts_id' => $contact->id,
                        ])->first();

                        if($edit == null){
                            $save = new ContactAddress();
                            $save->post_code = $value;
                            $save->contacts_id = $contact->id;
                            $save->save();
                        }
                        else{
                            $edit->post_code = $value;
                            $edit->save();
                        }
                    }
                }
            }
        }

        return redirect('contacts')->with('alert', 'Contact updated!');
    }
}
