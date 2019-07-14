<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function upload(REQUEST $request){
        $base = 'articles/'.$_REQUEST['id_article'].'/';
        $root = config('global_var.link_root').'public/articles/'.$_REQUEST['id_article'].'/';
        $relpath = isset($_REQUEST['baseurl']) ?  $_REQUEST['baseurl'] : ''; 
        // Use options.uploader.pathVariableName
        
        $path = $root;

        $hash= $_REQUEST['pic_hash'];
        if (!file_exists('articles/'.$_REQUEST['id_article'])) {
            mkdir('articles/'.$_REQUEST['id_article'], 0777, true);
        }
        
        // Do not give the file to load into the category that is lower than the root
        if (realpath($root.$relpath) && is_dir(realpath($root.$relpath)) && strpos(realpath($root.$relpath).'/', $root) !== false) {
            $path = realpath($root.$relpath).'/';
        }
        
        // Black and white list
        $config = [
            'white_extensions' => ['png', 'jpeg', 'gif', 'jpg'],
            'black_extensions' => ['php', 'exe', 'phtml'],
        ];
        
        $result = (object)['error'=> 0, 'messages'=>'', 'files'=>''];
                
        //Here 'images' is options.uploader.filesVariableName
        if (isset($_FILES['files'])) {
            $tmp_name = $_FILES['files']['tmp_name'];
            if (move_uploaded_file($tmp_name[0],$file= $base.$this->makeSafe($hash."_".$_FILES['files']['name'][0]))) {
                $info = pathinfo($file);
                // check whether the file extension is included in the whitelist
                if (isset($config['white_extensions']) and count($config['white_extensions'])) {
                    if (!in_array(strtolower($info['extension']), $config['white_extensions'])) {
                        unlink($file);
                        $result->messages='File type not in white list';
                    }
                }
                //check whether the file extension is included in the black list
                if (isset($config['black_extensions']) and count($config['black_extensions'])) {
                    if (in_array(strtolower($info['extension']), $config['black_extensions'])) {
                        unlink($file);
                        $result->messages='File type in black list';
                    }
                }
                $result->messages = 'File '.$hash."_".$_FILES['files']['name'][0].' was upload';
                $result->files = $base.basename($file);
                } else {
                    $result->error = 5;
                    if (!is_writable($path)) {
                        $result->messages='Destination directory is not writeble';
                    } else {
                        $result->messages='No images have been uploaded';
                    }
                }
            }

        return json_encode($result);
    }

    public function tree(Request $request){
        $root       = '../public/articles/tmp/';
        $relpath    = isset($_REQUEST['path']) ?  $_REQUEST['path'] : '';
        $action     = isset($_REQUEST['action']) ?  $_REQUEST['action'] : 'items';

        $path = $root;
        if (realpath($root.$relpath) && strpos(realpath($root.$relpath), $root) !== false) {
            $path = realpath($root.$relpath).DIRECTORY_SEPARATOR;
        }

        $result = (object)['error'=> 0, 'msg'=>[], 'files'=> [], 'path' => str_replace($root, '', $path)];

        $result->files[] = $path; 

        $dir = opendir($path);
        
        while ($file = readdir($dir)) {
            if ($file != '.' && $file != '..' && is_dir($path.$file)) {
                $result->files[] = $file;
            }
        }
        return json_encode($result);
    }

    public function items(Request $request){
        $root = '../public/articles/tmp/';
        $relpath    = isset($_REQUEST['path']) ?  $_REQUEST['path'] : '';
        $action     = isset($_REQUEST['action']) ?  $_REQUEST['action'] : 'items';
        


        // always check whether we are below the root category is not reached
        $path = $root;
        if (realpath($root.$relpath) && strpos(realpath($root.$relpath), $root) !== false) {
            $path = realpath($root.$relpath).DIRECTORY_SEPARATOR;
        }
        
        $result = (object)['error'=> 0, 'msg'=>[], 'files'=> [], 'path' => str_replace($root, '', $path)];
                
        switch ($request->action) {
            case 'items':
                $rooturl ='../articles/tmp/';
                $dir = opendir($path);
                while ($file = readdir($dir)) {
                    if (is_file($path.$file) && preg_match('#\.(png|jpg|jpeg|jpg|gif)$#i', $file)) {
                        $result->files[] = $file;
                    }
                }
            break;
            case 'folder':
                $result->files[] = $path == $root ? '.' : '..';
                $dir = opendir($path);
                while ($file = readdir($dir)) {
                    if ($file != '.' && $file != '..' && is_dir($path.$file)) {
                        $result->files[] = $file;
                    }
                }
            break;
        
        }
        exit(json_encode($result));
    }

    // function for creating safe name of file
    private function makeSafe($file) {
        $file = rtrim($file, '.');
        $regex = ['#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#'];
        return trim(preg_replace($regex, '', $file));
    }
}
