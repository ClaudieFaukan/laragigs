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
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
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

        Listing::create($formFields);

        return redirect('/')->with('success', 'Job created succesfully!');
    }
}
