<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $members = Member::all();
      $member  = null;
      return Inertia::render('App', compact('members', 'member'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required',
        'dni'  => 'required|unique:members'
      ]);

      $member = Member::create($request->all());

      if( $request->hasFile('picture') ){
        $member->addMediaFromRequest('picture')->toMediaCollection('picture');
      }

      return to_route('members.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
      $member->update($request->except(['id']));
      if( $request->hasFile('picture') ){
        $member->addMediaFromRequest('picture')->toMediaCollection('picture');
      }
      return to_route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}
