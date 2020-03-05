<?php


namespace App\Http\View\Composers;


use App\Repositories\Contracts\Categories\CategoriesRepositoryInterface;
use App\Repositories\Contracts\Post\PostRepositoryInterface;
use Illuminate\View\View;
class MasterClientComposer
{
    protected $category,
        $postRepository;

    public function __construct(CategoriesRepositoryInterface $category, PostRepositoryInterface $postRepository)
    {
        $this->category = $category;
        $this->postRepository = $postRepository;
    }

    public function compose(View $view){
        $list_categories = $this->category->getTop();
        $post_high = $this->postRepository->getHighTop();

        $view->with('list_category', $list_categories)->with('post_high', $post_high);
    }
}
