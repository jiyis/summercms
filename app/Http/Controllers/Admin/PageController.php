<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\ResourceManage;
use App\Repository\PageRepository;
use App\Services\CommonServices;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreatePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use Breadcrumbs, Toastr;
use App\Http\Controllers\Admin\Traits\SeoManage;

class PageController extends BaseController
{
    use SeoManage, ResourceManage;

    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-page', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('页面管理', route('admin.page.index'));
        });
        $this->pageRepository = $pageRepository;
        view()->share('layouts',CommonServices::getLayouts());

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Breadcrumbs::register('admin-page-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-page');
            $breadcrumbs->push('页面列表', route('admin.page.index'));
        });
        $pages = $this->pageRepository->all();
        return view('admin.page.index',compact('pages'));
    }

    public function create()
    {
        Breadcrumbs::register('admin-page-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-page');
            $breadcrumbs->push('新增页面', route('admin.page.create'));
        });
        return view('admin.page.create');
    }

    public function store(CreatePageRequest $request)
    {
        $input = $this->standUrl($request->all());
        $page = $this->pageRepository->create($input);
        if(!$page) {
            Toastr::error('页面添加失败!');
            return redirect(route('admin.page.create'));
        }
        $seo = $this->saveSeo($input, $page->id);
        $this->generatePage($input, $seo, $page);
        Toastr::success('页面添加成功!');
        return redirect(route('admin.page.edit', $page->id));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-page-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-page');
            $breadcrumbs->push('编辑页面', route('admin.page.edit', ['id' => $id]));
        });

        $page = $this->pageRepository->find($id);
        $page = $this->getSeo($page, 'page');

        return view('admin.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePageRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePageRequest $request, $id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Toastr::error('页面未找到');

            return redirect(route('admin.page.index'));
        }
        $input = $this->standUrl($request->all());
        $this->pageRepository->update($input, $id);
        $seo = $this->saveSeo($input, $id);
        $this->generatePage($input, $seo, $page);
        Toastr::success('页面更新成功.');

        return redirect(route('admin.page.edit', $id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);
        if (empty($page)) {
            Toastr::error('页面未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->pageRepository->delete($id);

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }

}