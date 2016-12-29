<?php

namespace app\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Smarty;

/**
 * 生成markdown的统计数据
 * Class Markdown
 * @package app\Console\Commands
 */
class Markdown extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'markdown';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'markdown';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make code';

    /** @var \Ytake\LaravelSmarty\SmartyFactory $factory */
    protected $factory;

    /** @var \Illuminate\Config\Repository $config */
    protected $config;

    /** @var \Ytake\LaravelSmarty\Engines\SmartyEngine */
    protected $engine;



    /**
     * 生成框架代码的步骤和流程
     * 1. 获取框架代码的配置 ok
     * 2. 使用框架的模板文件 ok
     * 3. 生成代码路径配置
     * 4. 根据模板文件生成指定的代码情况
     *
     * @return mixed
     */
    public function handle()
    {
        echo " Start make code !\n";

        $this->filesystem = new Filesystem();

        $this->loadSmartyTemplate();


        echo " End make code !\n";
    }


    /**
     * 清理删除代码的目录
     * 描述：
     *  循环删除指定目录的下的文件
     * 重点是 database/app 下的所有文件
     * @param $path
     */
    private function cleanDir($path){
        if(!file_exists($path)){
            mkdir($path);
        }
        if ( $handle = opendir( "$path" ) ) {
            while ( false !== ( $item = readdir( $handle ) ) ) {
                if ( $item != "." && $item != ".." ) {
                    if ( is_dir( "$path/$item" ) ) {
                        $this->cleanDir( "$path/$item" );
                    } else {
                        unlink( "$path/$item" );
                    }
                }
            }
            closedir( $handle );
            rmdir( $path );
        }
    }

    /**
     * 生成操作
     * @param $data
     * @param $type
     * @param $templateName
     * @param string $postfix
     */
    private function make($data,$type,$templateName,$postfix=''){

        $outputPath ='';
        $tpl = $this->engine->get("{$templateName}.tpl",$data);

        if(isset($this->pathArr[$type])){
            if(!$this->filesystem->isDirectory($this->pathArr[$type])){
                //mkdir($this->pathArr[$type]);
                $this->mkdirs($this->pathArr[$type]);
            }

            //过滤掉不需要的模块目录,如sql和路由
            if(!in_array($type , [self::TYPE_SQL,self::TYPE_ROUTES])){
                $path = $this->pathArr[$type] . $data['moduleName'];
                if(!$this->filesystem->isDirectory($path)){
                    mkdir($path);
                }
            }else{
                $path = $this->pathArr[$type];
                if(!$this->filesystem->isDirectory($path)){
                    mkdir($path);
                }
            }
        }else{

            //依赖于模块的路径，如单元测试的目录依赖于services模块的地址
            $path = '';
        }

        switch ($type){

            case self::TYPE_MOUDLE_SERVICES:
                $outputPath = $path.'/'.$data['moduleName']."{$postfix}.php";
                break;

            case self::TYPE_SQL:
            case self::TYPE_ROUTES:

                $outputPath = $path.$data['module'][0]['moduleName']."{$postfix}.php";
                break;

            case self::TYPE_TESTS:
                $type = self::TYPE_SERVICES;
                if(!$this->filesystem->isDirectory($this->pathArr[$type])){
                    mkdir($this->pathArr[$type]);
                }

                $path = $this->pathArr[$type] . $data['moduleName'].'/__tests__';
                if(!$this->filesystem->isDirectory($path)){
                    mkdir($path);
                }
                $outputPath = $path.'/'.$data['className']."{$postfix}.php";
                break;
            case self::TYPE_MODEL: //支持多个model生成的方式@@
                if(isset($data[self::CODE_MODEL])
                    && !empty($data[self::CODE_MODEL])){
                    foreach ($data[self::CODE_MODEL] as $k=>$v){
                        $v['fillFields'] = $this->getFillFields($v['fillFields']);
                        $v[self::IS_MODEL] = 1;
                        $tpl = $this->engine->get("{$templateName}.tpl",$v);
                        $outputPath = $path.'/'.$v['name']."{$postfix}.php";
                        file_put_contents($outputPath, $tpl);
                    }
                }else{
                    $outputPath = $path.'/'.$data['className']."{$postfix}.php";
                    file_put_contents($outputPath, $tpl);
                }
                return ;
                break;

            default:
                $outputPath = $path.'/'.$data['className']."{$postfix}.php";
                break;

        }
        file_put_contents($outputPath, $tpl);
    }

    private function mkdirs($dir){
        return is_dir($dir) or ($this->mkdirs(dirname($dir)) and mkdir($dir,0777));
    }


    /**
     * 过滤掉不符合条件的配置类，或者后期直接给出提示，xxx类没有设置
     * 1. 如没有设置className 的配置类
     * 2.
     * @param $value
     * @return bool
     */
    private function isFilter($value){

        if(empty($value['className'])){
            return true;
        }
        return false;
    }

    /**
     * 处理参数配置
     * 1. 增加Service层级需要的参数信息
     * 2. 处理content 参数
     * @param $classInfo 类的信息
     * @return mixed
     */
    private function handleCfg($classInfo){

        $classInfo['method'] = $this->handleMethod($classInfo['method']);
        $classInfo['classNote'] = $this->handleClassNote($classInfo['classNote']);
        return $classInfo;
    }

    private function handleClassNote($classNote){
        $str = '@description  '. $classNote."\r\n" .
                '@author  '.$this->codeInfo['authors'][0]['name']."\r\n" .
                '@email  '.$this->codeInfo['authors'][0]['email']."\r\n" .
                '@date '.date("Y-m-d",time());

        $arr = explode("\r\n",$str);
        $tmp = array();
        foreach ($arr as $k => $v){
            $tmp[] = " * ".$v;
        }
        return implode("\r\n",$tmp);

        return  $implode("\r\n",$tmp);
    }


    /**
     * 处理参数配置
     * 1. 增加Service层级需要的参数信息
     * 2. 处理content 参数
     * @param $method
     */
    private function handleMethod($method){

        foreach ($method as $key=>$val){

            $val['methodNoteDetail'] = $this->parseNote($val['methodNote']);

            //判断是否有多个service
            if(isset($val[self::CODE_SERVICE])
                && !empty($val[self::CODE_SERVICE])){

                $val[self::IS_SERVICE] = 1;
            }else{
                $val[self::IS_SERVICE] = 0;
            }

//            //判断是否有多个model
//            if(isset($val[self::CODE_MODEL])
//                && !empty($val[self::CODE_MODEL])){
//
//                $val[self::IS_MODEL] = 1;
//            }else{
//                $val[self::IS_MODEL] = 0;
//            }

            $val = $this->handleInParam($val);

            $method[$key] = $this->handleContent($val);
        }
        return $method;
    }


    /**
     * 处理输入的参数，这里只针对控制器层的输入参数
     * 1. 默认不设置validate,表示required判断
     * 2. 设置optional ,表示 不需要验证
     * 3. 其他的就根据用户配置生成，如
     *     ['email'=> 'required|email']
     *
     * @param $val
     * @return mixed
     */
    private function handleInParam($val){

        if(!empty($val[self::CODE_IN_PARAM])){
            foreach ($val[self::CODE_IN_PARAM] as $k=> $v){

                //$tmp = $v;
                if(!isset($v[self::CODE_VALIDATE])
                || empty($v[self::CODE_VALIDATE])){
                    $val[self::CODE_IN_PARAM][$k][self::CODE_VALIDATE] = 'required';
                }
            }
        }
        return $val;
    }

    /**
     * 对于内容进行处理，把注释“//”加入到内容的前面，方便代码直接的修改
     * 1. 检查方法本身是有content 对应的内容，如果没有，则默认设置''
     * 2. 对于存在service方法的情况， 需要给每个service 的内容进行加注释
     * 3. 检查其他的方法是否包含content的参数
     * @param $val
     */
    private function handleContent($val){

        if(!isset($val[self::CODE_CONTENT])){
            $val[self::CODE_CONTENT] = '';
        }else{
            $val[self::CODE_CONTENT] = $this->parseContent($val[self::CODE_CONTENT]);
        }

       if(isset($val[self::CODE_SERVICE]) && !empty($val[self::CODE_SERVICE])){
            foreach ($val[self::CODE_SERVICE] as $k => $v){
                $val[self::CODE_SERVICE][$k][self::CODE_CONTENT] = isset($v[self::CODE_CONTENT])
                    ? $this->parseContent($v[self::CODE_CONTENT]) : '';
            }
       }
       return $val;
    }

    /**
     * 对于内容进行处理，把注释“//”加入到内容的前面，方便代码直接的修改
     * @param $content
     * @return mixed
     */
    private function parseContent($content){

        $str = '';
        if(empty($content)){
            return '';
        }
        $arr = explode("\r\n",$content);
        foreach ($arr as $k => $v){
            $str .= "//".$v."\r\n";
        }
        return $str;
    }



    /**
     * 对方法的描述的解析，在内容前加上”*“字样
     * @param $note
     * @return string
     */
    private function parseNote($note){

        if(empty($note)){
            return '';
        }
        $arr = explode("\r\n",$note);
        $tmp = array();
        foreach ($arr as $k => $v){
            $tmp[] = "\t*".$v;
        }
        return implode("\r\n",$tmp);
    }



    /**
     * 获取框架的配置
     */
    public function getCfg(){

        /** 采用类的获取方式 */
        $codePath = base_path('database\makecfg\Code.php');
        require_once $codePath;

        /** 根据指定的路径或模块来生成代码 */
        $code = new Code($this->path);
        $data = $code->getCfg();
        $this->codeInfo = $code->getCodeInfo();
        return $data;
    }

    public function initOutputPath(){

        //$basePath = base_path('database/makecode/');

        //@todo 把配置的路径放到D:/tmp目录
        $basePath = 'D:/tmp/database/makecode/';
        $this->pathArr = [
            self::TYPE_MODEL=>$basePath.'app/Eloquent/',
            self::TYPE_EXCEPTIONS=>$basePath.'app/Exceptions/',
            self::TYPE_CONTROLLERS=>$basePath.'app/Http/Controllers/',
            self::TYPE_ROUTES=>$basePath.'app/Http/Routes/',
            self::TYPE_SERVICES=>$basePath.'app/Services/',
            self::TYPE_DATABASE=>$basePath.'database/',
            self::TYPE_SEEDS=>$basePath.'database/seeds/',
            self::TYPE_MOUDLE_SERVICES=>$basePath.'app/Services/',
            self::TYPE_MARKDOWN =>$basePath.'markdown/',
            self::TYPE_PHA =>$basePath.'pha/',
            self::TYPE_SQL =>$basePath.'sql/',
            self::TYPE_CONSOLE => $basePath.'app/Console/'

        ];
    }

    private function getFillFields($fillFields){
        if(empty($fillFields)){
            return ;
        }
        $str = '';
        foreach ($fillFields as $v){
            $str .= "'$v',";
        }
        return substr($str,0,strlen($str)-1);

    }

    /**
     * 加载SmartyTemplate的处理方式
     */
    public function loadSmartyTemplate(){
        $this->config = new \Illuminate\Config\Repository();
        $filesystem = new \Illuminate\Filesystem\Filesystem;

        $configPath = base_path('config/ytake-laravel-smarty.php');
        $items = $filesystem->getRequire($configPath);
        $this->config->set("ytake-laravel-smarty", $items);

        new \Illuminate\Config\Repository();
        $viewFinder = new \Illuminate\View\FileViewFinder(
            $filesystem,
            ['views'],
            ['.tpl']
        );
        $this->factory = new \Ytake\LaravelSmarty\SmartyFactory(
            new \Illuminate\View\Engines\EngineResolver,
            $viewFinder,
            new \Illuminate\Events\Dispatcher,
            new Smarty,
            $this->config
        );
        $this->factory->setSmartyConfigure();
        $this->factory->resolveSmartyCache();

        $extension = $this->config->get('ytake-laravel-smarty.extension', 'tpl');
        $this->factory->addExtension($extension, 'smarty', function () {
            // @codeCoverageIgnoreStart
            return new \Ytake\LaravelSmarty\Engines\SmartyEngine($this->factory->getSmarty());
            // @codeCoverageIgnoreEnd
        });

        $this->engine = new \Ytake\LaravelSmarty\Engines\SmartyEngine(
            $this->factory->getSmarty()
        );
    }


}
