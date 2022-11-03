<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all listings
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(10)
        ]);
    }

    //show a single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Show createform a listing
    public function create()
    {
        return view('listings.create');
    }

    //store a form listing
    public function store(Request $request)
    {

        $formFields = $request->validate(
            [

                'title' => 'required',
                'company' => ['required', Rule::unique('listings', 'company')],
                'location' => 'required',
                'website' => 'required',
                'email' => ['required', 'email'],
                'tags' => 'required',
                'description' => 'required'
            ]

        );

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields["user_id"] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('success', 'Job created succesfully!');
    }

    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing)
    {
        $formFields = $request->validate(
            [

                'title' => 'required',
                'company' => ['required'],
                'location' => 'required',
                'website' => 'required',
                'email' => ['required', 'email'],
                'tags' => 'required',
                'description' => 'required'
            ]

        );

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('success', 'Job updated succesfully!');
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect("/")->with("success", "Listing Deleted Successfully");
    }

    public function manage()
    {
        return view('listings.manage', ["listings" => auth()->user()->listings()->get()]);
    }
}
