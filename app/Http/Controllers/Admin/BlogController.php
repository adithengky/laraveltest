<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ItemTag;
use App\Http\Requests\Admin\PostBlog;
use Illuminate\Support\Collection;
use DB;

class BlogController extends Controller
{
    public function index(Request $request) {
    	$limit = $request->limit;

    	$blog = Blog::with(['itemTag' => function($q) {
            $q->with('tag');
        }])
        ->paginate(isset($limit) ? $limit : 10);

        return $this->dataResponse($blog);
    }

    public function store(PostBlog $request) {
    	$input = $request->only('category_id', 'title', 'content', 'tags');
    	try {
    		DB::beginTransaction();
    		$findCategory = Category::find($input['category_id']);
    		if (!$findCategory) {
    			return $this->errorResponse('Category not found', 404);
    		}

    		$saveBlog = Blog::create($input);
    		$blogId = $saveBlog->id;

    		if (count($input['tags']) > 0) {
    			collect($input['tags'])->map(function($tag) use ($blogId) {
    				$saveTag = Tag::updateOrCreate(['tags_name' => $tag]);
    				$inputItemTag = [
    					'blog_id' => $blogId,
    					'tag_id' => $saveTag->id
    				];
    				$saveItemTag = ItemTag::updateOrCreate($inputItemTag);
    			});
    		}
    		DB::commit();
    	} catch(\Exception $e) {
    		DB::rollback();
    		return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error");
    	}
    	return $this->successResponse('Blog created');
    }

    public function edit(PostBlog $request, $id) {
    	$input = $request->only('category_id', 'title', 'content', 'tags');
    	try {
    		$findBlog = Blog::find($id);
    		if (!$findBlog) {
    			return $this->errorResponse('Blog not found', 404);
    		}
    		$findCategory = Category::find($input['category_id']);
    		if (!$findCategory) {
    			return $this->errorResponse('Category not found', 404);
    		}
    		DB::beginTransaction();
    		$saveBlog = $findBlog->fill($input)->save();
    		$blogId = $findBlog->id;
    		ItemTag::where('blog_id', $blogId)->delete();
    		if (count($input['tags']) > 0) {
    			collect($input['tags'])->map(function($tag) use ($blogId) {
    				$saveTag = Tag::updateOrCreate(['tags_name' => $tag]);
    				$inputItemTag = [
    					'blog_id' => $blogId,
    					'tag_id' => $saveTag->id
    				];
    				ItemTag::create($inputItemTag);
    			});
    		}
    		DB::commit();
    	} catch(\Exception $e) {
    		DB::rollback();
    		return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error");
    	}
    	return $this->successResponse('Blog updated');
    }

    public function show($id) {
    	$findBlog = Blog::where('id', $id)
    		->with(['itemTag' => function($query) {
    			$query->with('tag');
    		}])
    		->first();
    	if (!$findBlog) {
    		return $this->errorResponse('Blog not found', 404);
    	}

    	return $this->dataResponse($findBlog);
    }

    public function showTag($id) {
        $findBlog = Tag::where('id', $id)
            ->with(['itemTag' => function($query) {
                $query->with(['blog' => function($query) {
                    $query->with(['itemTag' => function($query) {
                        $query->with('tag');
                    }]);
                }]);
            }])
            ->first();
        if (!$findBlog) {
            return $this->errorResponse('Blog not found', 404);
        }

        return $this->dataResponse($findBlog);
    }

    public function destroy($id) {
    	try {
    		$findBlog = Blog::find($id);
    		if (!$findBlog) {
    			return $this->errorResponse('Blog not found', 404);
    		}
			Blog::destroy($id);
    	} catch(\Exception $e) {
    		return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error"); 
    	}
    	return $this->successResponse('Blog deleted');
    }

    public function showArchive() {
        try {
            $blogs = Blog::select(DB::raw('MONTHNAME(created_at) as month, YEAR(created_at) as year, MONTH(created_at) as monthInt'))
            ->distinct()
            ->get();
        } catch(\Exception $e) {
            return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error");
        } 
    	
    	return $this->dataResponse($blogs);
    }

    public function showCategory($id) {
        try {
            $blogs = Blog::with(['itemTag' => function($q) {
                $q->with('tag');
            }])
            ->where('category_id', $id)
            ->paginate(10);  
        } catch(\Exception $e) {
            return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error");
        }
        return $this->dataResponse($blogs);
    }

    public function indexArchive(Request $request) {
        $date = $request->date;
        $explode = explode('-', $date);
        try {
            $blogs = Blog::with(['itemTag' => function($q) {
                    $q->with('tag');
                }])
                ->where(DB::raw('Month(created_at)'), $explode[0])
                ->where(DB::raw('Year(created_at)'), $explode[1])
                ->paginate(10);
        } catch(\Exception $e) {
            return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error");
        }
        return $this->dataResponse($blogs);
    }
}
