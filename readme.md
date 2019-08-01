## Metaweblog API
* test: http://olw.test.sj22/api/v1/test1
* request, response 모두 xml
* struct 1개 문제
* 서비스프로바이더, 계정 등록
    * getUsersBlogs
    * getCategories
    * getRecentPosts
* 게시
    * newPost: 포스트 생성일 경우 호출
    * newMediaObject: 새 이미지의 경우 파일과 섬네일 2번 호출
        * 파일 지울때 별도 메소드 호출이 없음
    * editPost: 포스트 변경일 경우 호출
    * getPost

## ref
* https://docs.microsoft.com/ko-kr/previous-versions/web-development/windows-live/bb259697(v=msdn.10)
* https://codex.wordpress.org/XML-RPC_MetaWeblog_API
* https://github.com/jailtonsc/laravel-response-xml
* https://github.com/Tucker-Eric/laravel-xml-middleware
