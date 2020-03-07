<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\CategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Models\Admin;
use App\Models\Categories;
use App\Repositories\Contracts\Categories\CategoriesRepositoryInterface;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class CategoryController extends Controller
{
    protected $categoriesRepository;

    /**
     * CategoryController constructor.
     * @param CategoriesRepositoryInterface $categoriesRepository
     */
    public function __construct(CategoriesRepositoryInterface $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'viewAny', Categories::class);
        return view('admin.category.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function data(Request $request){
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'viewAny', Categories::class);
        $columns = ['id', 'name', 'parent_id', 'description', 'thumb_img'];

        $limit = $request->input('length');
        $limit = ($limit) ? $limit : 10;
        $start = $request->input('start');
        $start = ($start) ? $start : 0;
        $order = $columns[$request->input('order.0.column')];
        $order = ($order) ? $order : ['id'];
        $dir = $request->input('order.0.dir');
        $dir = ($dir) ? $dir : 'desc';

        $totalData = $totalFiltered = $this->categoriesRepository->count();

        $search = $request->input('search.value');
        $categories = $this->categoriesRepository->where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)->with('parent')->get();
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $categories
        );
        return response()->json($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * categories search with name
     * @param null|string $name
     * @return mixed|array json
     */
    public function search(){
        $name = request()->input('q');
        return $this->categoriesRepository->search(['name', 'description'], $name)->where('parent_id', 0)
                ->get(['id', 'name as text'])->toJson();
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CategoryRequest $request)
    {
        dd($request->except(['_token']));
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'create', Categories::class);
        //save file
        $image = $request->file('thumb_img');
        $file_save = $this->save_file($image);
        $data_category = $request->all(['name', 'description', 'parent_id']);

        $data_category['thumb_img'] = $file_save;
        $category = $this->categoriesRepository->create($data_category);
        if (!empty($category)){
            return response([
                'errors' => false,
                'msg' => $data_category
            ]);
        }
        return response([
            'errors' => true,
            'msg' => 'errors'
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $post = $this->categoriesRepository->findOrFail($id);
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'update', $post);
        return $post || [];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $categories)
    {
        $id = request()->get('id');
        dd($id);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, int $id)
    {
        $data = $request->all(['name', 'description', 'thumb_img']);
        $category = $this->categoriesRepository->findOrFail($id);

        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'update', $category);

        $thumb_img = $request->file('thumb_img');
        if($request->file('thumb_img')){
            $data['thumb_img'] = $this->save_file($thumb_img);
        }
        foreach($data as $k => $value){
            $category->$k = $value;
        }
        return response([
            'updated' => $category->save()
        ]);
    }

    /**
     * @param UploadedFile $file
     * @return bool|false|string
     */
    public function save_file(UploadedFile $file){
        if (empty($file)){
            return false;
        }
        $path_time = date('Y/m');
        $name_file = time().'-'.$file->getClientOriginalName();
        $file_save = $file->storeAs($path_time, $name_file  ,'public');
        return $file_save;
    }

    /**
     * @param Categories $categories
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Categories $categories, $id)
    {
        $delete = $this->categoriesRepository->find($id);
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'delete', $delete);
        return response([
            'deleted' => $delete->delete()
        ]);
    }
}
