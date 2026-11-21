<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReorderSectionsRequest;
use App\Http\Requests\Admin\UpdateSectionRequest;
use App\Models\Section;
use App\Services\Admin\SectionService;
use App\Services\LocaleService;
use Illuminate\Support\Facades\Gate;

class SectionController extends Controller
{
    public function __construct(private SectionService $sections, private LocaleService $locales) {}

    public function index()
    {
        Gate::authorize('viewAny', Section::class);

        return view('admin.sections.index', ['sections' => $this->sections->all()]);
    }

    public function edit(Section $section)
    {
        Gate::authorize('update', $section);

        return view('admin.sections.edit', [
            'section' => $section->load('translations'),
            'locales' => $this->locales->active(),
        ]);
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        Gate::authorize('update', $section);

        $this->sections->update($section, $request->validated());

        return redirect()->route('admin.sections.index')->with('success', 'Section updated.');
    }

    public function toggle(Section $section)
    {
        Gate::authorize('update', $section);

        $this->sections->toggle($section);

        return back()->with('success', 'Section visibility changed.');
    }

    public function reorder(ReorderSectionsRequest $request)
    {
        Gate::authorize('viewAny', Section::class);

        $this->sections->reorder($request->validated('order'));

        return back()->with('success', 'Order saved.');
    }
}
