<?php

namespace MediaWebId\OurWorks\Http\Controllers\Backend;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Facades\MediaWebId\OurWorks\Http\Repositories\OurWorksRepository;
use Illuminate\Support\Facades\Cache;
use MediaWebId\OurWorks\Http\Requests\OurWorksRequest;
use MediaWebId\OurWorks\Http\Resources\Backend\OurWorksResource;
use MediaWebId\OurWorks\Models\OurWorks;

class OurWorksController extends Controller {

    public function index() {
        $ourworks = OurWorksRepository::paginate(20);

        return Inertia::render('our-works/index', [
            'ourworks' => OurWorksResource::collection($ourworks),
            'title' => request('trash') ? 'Trash' : 'Our Works',
            'trash' => request('trash') ? true : false,
            'request' => request()->all(),
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Our Works',
                    'url' => route('ourwork.index'),
                ],
            ],
        ]);
    }

    /**
     * Create view
     */
    public function create() {
        $ourwork = new OurWorks();
        $ourwork = OurWorksResource::make($ourwork)->resolve();

        return Inertia::render('our-works/form', [
            'ourwork' => $ourwork,
            'method' => 'store',
            'title' => 'Create '.'Our Work',
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Our Works',
                    'url' => route('ourwork.index'),
                ],
            ],
        ]);
    }

    /**
     * store data to Database
     */
    public function store(OurWorksRequest $request) {
        $ourwork = OurWorks::create($request->all());

        Cache::tags(['ourworks'])->flush();
        return redirect()->back()->with('message', toTitle($ourwork->title).'has been created');
    }

    /**
     * Edit view.
     */
    public function edit(OurWorks $ourwork)
    {
        return Inertia::render('our-works/form', [
            'our_work' => OurWorksResource::make($ourwork)->resolve(),
            'method' => 'update',
            'title' => 'Edit '.'Our Work',
            'locale' => app()->getLocale(),
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Our Works',
                    'url' => route('ourwork.index'),
                ],
            ],
        ]);
    }

    /**
     * Update Data.
     */
    public function update(OurWorksRequest $request, OurWorks $ourwork)
    {
        $ourwork->update($request->all());

        Cache::tags(['ourworks'])->flush();
        return redirect()->back()->with('message', toTitle($ourwork->title).' has been updated');
    }

    /**
     * Remove the specified resource from storage temporary.
     */
    public function delete($ourwork)
    {
        $ourwork = OurWorks::find($ourwork);
        if (!$ourwork) {
            return abort(404);
        }
        $ourwork->delete();

        Cache::tags(['ourworks'])->flush();

        return redirect()->route('ourwork.index')->with('message', toTitle($ourwork->title.' hase been deleted'));
    }

    /**
     * Remove data permanently.
     */
    public function destroy($ourwork)
    {
        $ourwork = OurWorks::withTrashed()->find($ourwork);
        if (!$ourwork) {
            return abort(404);
        }
        $ourwork->forceDelete();

        Cache::tags(['ourworks'])->flush();

        return redirect()->route('ourwork.index')->with('message', toTitle($ourwork->title.' hase been destroyed'));
    }

    public function destroyAll()
    {
        $ids = explode(',', request('selected'));
        $ourworks = OurWorks::whereIn('_id', $ids)->withTrashed()->get();
        foreach ($ourworks as $ourwork) {
            $ourwork->forceDelete();
        }
        Cache::tags(['ourworks'])->flush();

        return redirect()->route('ourwork.index')->with('message', toTitle($ourwork->title).' has been destroyed');
    }

    /**
     * Restore Data from trash.
     */
    public function restore($ourwork)
    {
        $ourwork = OurWorks::withTrashed()->find($ourwork);
        if (!$ourwork) {
            return abort(404);
        }
        $ourwork->restore();
        Cache::tags(['ourworks'])->flush();

        return redirect()->route('ourwork.index')->with('message', toTitle($ourwork->title).' has been restored');
    }
}
