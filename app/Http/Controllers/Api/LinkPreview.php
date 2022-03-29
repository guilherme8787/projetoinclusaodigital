<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dusterio\LinkPreview\Client;
use App\Models\Thumb;

class LinkPreview extends Controller
{

    public function fileGetByUrl($url){

        $http = false;
        $https = false;

        if(str_contains($url, 'http://')){
            $http = true;
        }
        if(str_contains($url, 'https://')){
            $https = true;
        }

        if($http == false && $https == false){
            $url = 'https://'.$url;
        }

        $arrContextOptions = array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.109 Safari/537.36 OPR/84.0.4316.42"
            )
        ); 
        return file_get_contents($url, false, stream_context_create($arrContextOptions));
    }

    public function getSiteInfo($url){
        $previewClient = new Client($url);
        $previews = $previewClient->getPreviews();
        $preview = $previewClient->getPreview('general');
        return $preview->toArray();
    }

    public function get(Request $request){ 

        if($request->filled('url')){

            $url_de_busca = null;
            $url_de_opcao = null;
            $url_explodido = explode(';', $request->get('url'));
            foreach($url_explodido as $url){
                if(str_contains($url, 'play.google.com')){
                    $url_de_busca = $url;
                } else {
                    if(!empty($url)){
                        $url_de_opcao = $url;
                    }
                }
            }

            if($url_de_opcao == null && $url_de_busca != null){
                $url_request = $url_de_busca;
            } else if($url_de_busca == null && $url_de_opcao != null) {
                $url_request = $url_de_opcao;
            } else if($url_de_busca != null && $url_de_opcao != null) {
                $url_request = $url_de_busca;
            } else {
                $url_request = $request->get('url');
            }

            $url_request = str_replace('https://http://', 'http://', $url_request);

            if(str_contains($url, 'wikipedia')){
                $url_request = 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/Wikipedia-logo-v2-pt.svg/892px-Wikipedia-logo-v2-pt.svg.png';
            }
            if(str_contains($url, 'youtube')){
                if(!str_contains($url, 'youtube.kids')){
                    $url_request = 'https://inclusaodigitalnasescolas.com.br/storage/img/youtube.png';
                }
            }
            if(str_contains($url, 'pixabay')){
                $url_request = 'https://cdn.pixabay.com/photo/2017/01/17/14/44/pixabay-1987090_1280.png';
            }

 
            if($preview = $this->getSiteInfo($url_request)){
                if(empty($preview['cover'])){
                    if(is_array($preview['images'])){
                        if(isset($preview['images'][0])){
                            $contents = $preview['images'][0];
                        } else {
                            $contents = false;
                        }
                    } else {
                        if(isset($preview['images'])){
                            $contents = $preview['images'];
                        } else {
                            $contents = false;
                        }
                    }
                } else {
                    if(isset($preview['cover'])){
                        $contents = $preview['cover'];
                    } else {
                        $contents = false;
                    }
                }
            } else {
                $contents = false;
            }

            if($contents == false){
                $contents = 'https://inclusaodigitalnasescolas.com.br/storage/img/nothuhmbpng.png';
            }

            if(str_contains($url, 'http://')){
                $contents = 'https://inclusaodigitalnasescolas.com.br/storage/img/nothuhmbpng.png';
            }

            if(!str_contains($url, 'http://') && !str_contains($url, 'https://')){
                $contents = 'https://inclusaodigitalnasescolas.com.br/storage/img/nothuhmbpng.png';
            }

            if(str_contains($url, 'wikipedia')){
                $contents = 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/Wikipedia-logo-v2-pt.svg/892px-Wikipedia-logo-v2-pt.svg.png';
            }
            if(str_contains($url, 'youtube')){
                if(!str_contains($url, 'youtube.kids')){
                    $contents = 'https://inclusaodigitalnasescolas.com.br/storage/img/youtube.png';
                }
            }
            if(str_contains($url, 'pixabay')){
                $contents = 'https://cdn.pixabay.com/photo/2017/01/17/14/44/pixabay-1987090_1280.png';
            }

            return response()->json(['img' => $contents]);

        } else {
            return response()->json(['404']);
        }
    }
}

