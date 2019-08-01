<?php

namespace App\Http\Controllers\Api\v1;

use apanly\metaweblog\MetaWeblog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('xml');
    }

    private function mwEditPost()
    {
        $out = ['params' => ['param' => ['value' => ['boolean' => 1] ] ] ];
        return $out;
    }

    private function mwGetCategories()
    {
        $out = ['params' => ['param' => ['value' => ['array' => ['data' => ['value' => ['struct' => []]]]]]]];
        $out['params']['param']['value']['array']['data']['value']['struct'] = [
            [ 'name' => 'categoryId', 'value' => 1, ],
            [ 'name' => 'categoryName', 'value' => 'foo', ],
            [ 'name' => 'description', 'value' => 'foo', ],
        ];

        return $out;
    }

    private function mwGetPost()
    {
        $out = ['params' => ['param' => ['value' => ['array' => ['data' => ['value' => ['struct' => []]]]]]]];
        $out['params']['param']['value']['array']['data']['value']['struct'] = [
            [ 'name' => 'postid', 'value' => [ 'string' => '100' ] ],
            [ 'name' => 'dateCreated', 'value' => [ 'dateTime.iso8601' => '20030729T10:59:48' ] ],
            [ 'name' => 'title', 'value' => 'foo' ],
            [ 'name' => 'description', 'value' => 'bar' ],
            [ 'name' => 'categories', 'value' => [ 'array' => [ 'data' => [ 'value' => 'bar' ] ] ] ],
            [ 'name' => 'publish', 'value' => [ 'boolean' => 1 ] ],
        ];
        return $out;
    }

    private function mwGetRecentPosts()
    {
        $out = ['params' => ['param' => ['value' => ['array' => ['data' => ['value' => ['struct' => []]]]]]]];
        $out['params']['param']['value']['array']['data']['value']['struct'] = [];
        return $out;
    }

    private function mwGetUsersBlogs()
    {
        $out = ['params' => ['param' => ['value' => ['array' => ['data' => ['value' => ['struct' => []]]]]]]];
        $out['params']['param']['value']['array']['data']['value']['struct'] = [
            [ 'name' => 'blogid', 'value' => 'foo', ],
            [ 'name' => 'url', 'value' => 'http://olw.test.sj22', ],
            [ 'name' => 'blogName', 'value' => 'bar', ],
        ];
        return $out;
    }

    private function mwNewMediaObject()
    {
        $out = ['params' => ['param' => ['value' => ['array' => ['data' => ['value' => ['struct' => []]]]]]]];
        $out['params']['param']['value']['struct'] = [
            [ 'name' => 'id', 'value' => 100 ], //XXX
            [ 'name' => 'file', 'value' => 'foo' ],
            [ 'name' => 'url', 'value' => 'http://bar.io' ],
            [ 'name' => 'type', 'value' => 'image/jpeg' ],
        ];
        return $out;
    }

    private function mwNewPost()
    {
        $out = ['params' => ['param' => ['value' => ['i4' => 100] ] ] ];
        return $out;
    }

    public function test1(Request $request)
    {
        //Log::info($request->getContent()); //Log::info(json_encode($request));
        $req = $request->xml(); //Log::info($req); Log::info('====');
        $reqMethod = 'mw' . ucfirst(explode('.', $req['methodName'])[1]); Log::info($reqMethod);
        $out = $this->$reqMethod();
        $tmpl = [ 'template' => '<methodResponse></methodResponse>', 'rowName' => ['member'] ];
        $out = response()->xml($out, Response::HTTP_OK, $tmpl); //Log::info($out);
        return $out;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @deprecated TEST
     * https://github.com/apanly/metaweblog
     */
    public function test2(Request $request)
    {
        $url = 'https://api.blog.naver.com/xmlrpc';
        //$url = 'http://olw.test.sj22/api/v1/test1';
        $target = new MetaWeblog($url);
        $userName = 'midnight__';
        $userPw = '7698dfa9826dfb2023cfbc394752037a';
        $target->setAuth($userName, $userPw); //dd($target);

        Log::info('====');
        //$params = [ 'title' => 'foo', 'description' => 'bar', ];
        //$target->newPost($params);
        //Log::info($target->getBlogId());

        $params = [ 'appkey' => 'foo', 'username' => $userName, 'password' => $userPw ];
        $out = $target->getUsersBlogs($params); Log::info($out);
        Log::info($target->getResponse());

        //Log::info($target->getErrorMessage());
        //Log::info($target->getErrorCode());
        //Log::info($target->isError());

        return response()->json([ 'data' => $target ], Response::HTTP_OK, [], JSON_PRETTY_PRINT);
    }

    public function test3()
    {
        $out = ['params' => ['param' => ['value' => ['array' => ['data' =>
            [
                [
                    [
                        [ 'name' => 'foo', 'value' => 1 ],
                        [ 'name' => 'bar', 'value' => 2 ],
                    ],
                    [
                        [ 'name' => 'foo', 'value' => 1 ],
                        [ 'name' => 'bar', 'value' => 2 ],
                    ],
                ],
                [
                    [
                        [ 'name' => 'foo', 'value' => 1 ],
                        [ 'name' => 'bar', 'value' => 2 ],
                    ],
                    [
                        [ 'name' => 'foo', 'value' => 1 ],
                        [ 'name' => 'bar', 'value' => 2 ],
                    ]
                ],
            ]
        ]]]]];

        $tmpl = [ 'template' => '<methodResponse></methodResponse>', 'rowName' => ['value', 'struct', 'member'] ];
        $out = response()->xml($out, Response::HTTP_OK, $tmpl);
        return $out;
    }
}
