<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSocialLinkRequest;
use App\Http\Requests\Admin\UpdateSocialLinkRequest;
use App\Models\SocialLink;
use App\Services\Admin\SocialLinkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SocialLinkController extends Controller
{
    public function __construct(private SocialLinkService $links) {}

    public function index()
    {
        Gate::authorize('viewAny', SocialLink::class);

        return view('admin.social-links.index', ['links' => $this->links->all()]);
    }

    public function create()
    {
        Gate::authorize('create', SocialLink::class);

        return view('admin.social-links.create', ['link' => new SocialLink(['is_active' => true])]);
    }

    public function store(StoreSocialLinkRequest $request)
    {
        Gate::authorize('create', SocialLink::class);

        $this->links->create($request->validated());

        return redirect()->route('admin.social-links.index')->with('success', 'Link added.');
    }

    public function edit(SocialLink $socialLink)
    {
        Gate::authorize('update', $socialLink);

        return view('admin.social-links.edit', ['link' => $socialLink]);
    }

    public function update(UpdateSocialLinkRequest $request, SocialLink $socialLink)
    {
        Gate::authorize('update', $socialLink);

        $this->links->update($socialLink, $request->validated());

        return redirect()->route('admin.social-links.index')->with('success', 'Link updated.');
    }

    public function destroy(SocialLink $socialLink)
    {
        Gate::authorize('delete', $socialLink);

        $this->links->delete($socialLink);

        return redirect()->route('admin.social-links.index')->with('success', 'Link deleted.');
    }

    public function reorder(Request $request)
    {
        Gate::authorize('viewAny', SocialLink::class);

        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'distinct', 'exists:social_links,id'],
        ]);

        $this->links->reorder($data['order']);

        return back()->with('success', 'Order saved.');
    }
}
