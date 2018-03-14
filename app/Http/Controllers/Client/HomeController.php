<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Http\Requests\Admin\PostBlog;

class HomeController extends Controller
{
	public $baseApi;
    public $archive;
	public function __construct() {
		$this->baseApi = 'http://localhost/laravel/public';
        $this->archive = $this->postApi($this->baseApi . '/api/admin/archive');
        $this->category = $this->postApi($this->baseApi . '/api/admin/category');
	}
    public function index(Request $request) {
    	$archive = $this->archive;
        if ($request->url) {
            $blog = $this->postApi($request->url);
        } else {
            $blog = $this->postApi($this->baseApi . '/api/admin/blogs'); 
        }

        $category = $this->category;
    	return view('components.main', compact('archive', 'blog', 'category'));
    }

    public function detail($id) {
        $archive = $this->archive;
        $blog = $this->postApi($this->baseApi . '/api/admin/blogs/' . $id); 
        $category = $this->category;
        return view('components.detail', compact('archive', 'blog', 'category'));
    }

    public function indexTags(Request $request) {
        $archive = $this->archive;
        $blog = $this->postApi($this->baseApi . '/api/admin/tags/' . $request->tags); 
        $category = $this->category;
        return view('components.tags', compact('archive', 'blog', 'category'));
    }

    public function indexByCategory($id) {
        $archive = $this->archive;
        $blog = $this->postApi($this->baseApi . '/api/admin/blog/category/' . $id); 
        $category = $this->category;
        return view('components.main', compact('archive', 'blog', 'category'));
    }

    public function indexArchive($id) {
        $archive = $this->archive;
        $blog = $this->postApi($this->baseApi . '/api/admin/archive/all?date=' . $id); 
        $category = $this->category;
        return view('components.main', compact('archive', 'blog', 'category'));
    }

    public function showPost() {
        $archive = $this->archive;
        $category = $this->category;
        return view('components.formpost', compact('archive', 'category'));
    }

    public function storeBlog(Request $request) {
        $input = $request->only('category_id', 'title', 'content', 'tags');
        $input['tags'] = explode(',', $input['tags']);
        $save = $this->postApi($this->baseApi . '/api/admin/blogs', $input, 'POST');
        return redirect('/');

    }

    public function postApi($api, $params = '', $method = '') {
    	try {
            $client = new Client();
            if ($method) {
                $postOption = [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'json' => $params,
                    'timeout' => env('API_TIMEOUT') ? env('API_TIMEOUT') : 25
                ];
                $response = $client->post($api, $postOption)->getBody();
            } else {
                $response = $client->get($api, [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'timeout' => env('API_TIMEOUT') ? env('API_TIMEOUT') : 25
                ])->getBody();    
            }
            
            $response = json_decode($response->getContents());
        } catch (\Exception $e) {
            $res = $this->parseResponse($e->getMessage());
            if ($res) {
                return $res;
            }
            return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Internal server error");
        } catch (RequestException $e) {
            return $this->errorResponse(env('APP_DEBUG') ? $e->getMessage() : "Request time out");
        }

        return $response;
    }
}
