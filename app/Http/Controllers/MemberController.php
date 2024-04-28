<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      return Inertia::render('App', [
        'members'       => fn() => Member::with('subscriptions.membership')->get(),
        'updatedMember' => Inertia::lazy(fn() => $request->filled('updated_id') ? Member::with('subscriptions.membership')->find($request->updated_id) : null),
        'createdMember' => Inertia::lazy(fn() => $request->filled('created_id') ? Member::with('subscriptions.membership')->find($request->created_id) : null),
      ]);
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
        'picture' => 'required|file|max:5000|mimes:jpeg,png',
        'name'    => 'required',
        'dni'     => 'required|unique:members'
      ]);

      $member = Member::create($request->all());

      if( $request->hasFile('picture') ){
        $member->addMediaFromRequest('picture')->toMediaCollection('picture');
      }

      return redirect()->route('members.index', ['created_id' => $member->id]);
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
      return to_route('members.index', ['updated_id' => $member->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }

    public function subscribe(Request $request, Member $member){
      $request->validate(['membership_id'=>'required']);
      $membership = Membership::findOrFail($request->membership_id);
      $subscription = $member->subscriptions()->create([
        'membership_id' => $membership->id,
        'member_id'     => $member->id,
        'expires_at'    => now()->addMonth()
      ]);
      return to_route('members.index', ['updated_id' => $member->id]);
    }
}
