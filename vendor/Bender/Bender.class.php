<?php
/**
 * @author Alex Raven
 * @company ESITEQ
 * @website http://www.esiteq.com/
 * @email bugrov at gmail.com
 * @created 29.10.2013
 * @version 0.2
 * improved by Rolland (rolland at alterego.biz.ua)
 */

class Bender
{
    // CSS minifier
    public $cssmin = "cssmin";
    // JS minifier, can be "packer" or "jshrink"
    public $jsmin = "jshrink";
    // Packed file time to live in sec (-1 = never recompile, 0 = always recompile, default: 3600)
    public $ttl = -1;
    // Project's root dir
    public $root_dir;
    // Constructor
    private $version_key = 'v';
    public function __construct()
    {
        $this->root_dir = DIR_FS_CATALOG;
    }
    // Enqueue CSS or Javascript
    public function enqueue( $src )
    {

        //$src = ltrim( $src, '/' );
        //$src = preg_replace('/'.ltrim(DIR_WS_CATALOG,'/').'/','',$src,1);

        global $_javascripts, $_stylesheets;
        if ( !is_array( $src ) )
        {
            $src = array( $src );
        }
        foreach ( $src as $s )
        {
            switch ( $this->get_ext( $s ) )
            {
                case "css":
                    $_stylesheets[] = $s;
                    break;
                case "js":
                    $_javascripts[] = $s;
                    break;
            }
        }
    }
    // Minify CSS / Javascripts and write output
    protected function minify( $scripts, $ext, $output )
    {
        $path = $this->root_dir();
        //$output = preg_replace('/'.ltrim(DIR_WS_CATALOG,'/').'/','',$output,1);
        //$output = str_replace('/',DIRECTORY_SEPARATOR,$output);
        //$outfile = $path.$output;
        
        foreach ($scripts as $key => $value) {
        	$files.=hash_file('sha1',DIR_FS_CATALOG.$value);
        }
        
        $hash = hash('sha1',$files);

        $outfile = $hash.'.'.$ext;
        $outfile_path = "templates/".CURRENT_TEMPLATE."/cache/".$outfile;
        $outfile = $path."templates/".CURRENT_TEMPLATE."/cache/".$outfile;

        if ( file_exists( $outfile ) )
        {
            if ( $this->ttl == -1 )
            {
                // never recompile
                return true;
            }
            $fileage = time() - filemtime( $outfile );
            if ( $fileage < $this->ttl )
            {
                return true;
            }
        }
        $str = $this->join_files( $scripts );
        switch ( $ext )
        {
            case "css":
                switch ( $this->cssmin )
                {
                    case "cssmin":
                        require_once realpath( dirname( __file__ ) . DIRECTORY_SEPARATOR . "cssmin.php" );
                        $compressor = new CSSmin();
                        $compressor->set_memory_limit('256M');
                        $compressor->set_max_execution_time(120);
                        $packed = $compressor->run($str);
                        break;
                    default:
                        $packed = $str;
                }
                break;
            case "js":
                switch ( $this->jsmin )
                {
                    case "packer":
                        require_once realpath( dirname( __file__ ) ) . DIRECTORY_SEPARATOR . "class.JavaScriptPacker.php";
                        $packer = new JavaScriptPacker( $str, "Normal", true, false );
                        $packed = $packer->pack();
                        break;
                    case "jshrink":
                        require_once realpath( dirname( __file__ ) ) . DIRECTORY_SEPARATOR . "JShrink.class.php";
                        $packed = Minifier::minify( $str );
                        break;
                    case "jsmin":
                        require_once realpath( dirname( __file__ ) ) . DIRECTORY_SEPARATOR . "jsminplus.php";
                        $packed = JSMinPlus::minify( $str );
                        break;
                    default:
                        $packed = $str;
                }
                break;
        }
        file_put_contents( $outfile, $packed );
    }
    // Print output for CSS or Javascript
    public function output( $output )
    {
        //$output = ltrim( $output, './' );
        global $_javascripts, $_stylesheets;
        switch ( $this->get_ext( $output ) )
        {
            case "css":

                $path = $this->root_dir();
                foreach ($_stylesheets as $key => $value) {
                 $files.=hash_file('sha1',DIR_FS_CATALOG.$value);
                }
        
                $hash = hash('sha1',$files);
                $outfile = $hash.'.css';
                $outfile_path = "templates/".CURRENT_TEMPLATE."/cache/".$outfile;
                $outfile = $path."templates/".CURRENT_TEMPLATE."/cache/".$outfile;

                $this->check_recombine( $outfile, $_stylesheets );
                $this->minify( $_stylesheets, "css", $outfile );
                return '<link href="' . $this->get_src( $outfile_path ) . '" rel="stylesheet" type="text/css"/>';
                //return '<script id="loadcss">function loadCSS(e,n,o,t){"use strict";var d=window.document.createElement("link"),i=n||window.document.getElementsByTagName("script")[0],r=window.document.styleSheets;return d.rel="stylesheet",d.href=e,d.media="only x",t&&(d.onload=t),i.parentNode.insertBefore(d,i),d.onloadcssdefined=function(e){for(var n,o=0;o<r.length;o++)r[o].href&&r[o].href===d.href&&(n=!0);n?e():setTimeout(function(){d.onloadcssdefined(e)})},d.onloadcssdefined(function(){d.media=o||"all"}),d}loadCSS("' . $this->get_src( $output ) . '", document.getElementById("loadcss"));</script><noscript><link href="' . $this->get_src($output) . '" rel="stylesheet"></noscript>';    
                break;
            case "js":

                $path = $this->root_dir();
                foreach ($_javascripts as $key => $value) {
                        $files.=hash_file('sha1',DIR_FS_CATALOG.$value);
                }
        
                $hash = hash('sha1',$files);
                $outfile = $hash.'.js';
                $outfile_path = "templates/".CURRENT_TEMPLATE."/cache/".$outfile;
                $outfile = $path."templates/".CURRENT_TEMPLATE."/cache/".$outfile;

                $this->check_recombine( $outfile, $_javascripts );
                $this->minify( $_javascripts, "js", $outfile );
                return '<script src="' . $this->get_src($outfile_path) . '"></script>';
                //return '<script>function loadJS(e,t){"use strict";var n=window.document.getElementsByTagName("script")[0],o=window.document.createElement("script");return o.src=e,o.async=!0,n.parentNode.insertBefore(o,n),t&&"function"==typeof t&&(o.onload=t),o}loadJS("' . $this->get_src($output) . '");</script>';
                
                break;
        }
    }
    // Get root dir
    protected function root_dir()
    {
        return $this->root_dir;
    }
    // Join array of files into a string
    protected function join_files( $files )
    {
        $path = $this->root_dir();
        if ( !is_array( $files ) )
        {
            return "";
        }
        $c = "";
        foreach ( $files as $file )
        {
            $c .= file_get_contents( "{$path}/{$file}" );
        }
        return $c;
    }
    // Get extension in lowercase
    protected function get_ext( $src )
    {
        return strtolower( pathinfo( $src, PATHINFO_EXTENSION ) );
    }
    /**
     * Gheck if need to recombine output file
     */
    protected function check_recombine( $output, $files )
    {
        $path = $this->root_dir();
        //$output = preg_replace('/'.ltrim(DIR_WS_CATALOG,'/').'/','',$output,1);
        //$output = str_replace('/',DIRECTORY_SEPARATOR,$output);
        //$outfile = $path.$output;
        $outfile = $output;
        if ( !file_exists( $outfile ) || !is_array( $files ) )
        {
            return;
        }
        // find last modify time of src
        $last = 0;
        foreach ( $files as $file )
        {
            if ( ( $_time = filemtime( $path . $file ) ) > $last )
                $last = $_time;
        }
        if ( filemtime( $outfile ) < $last )
        {
            // need to be recombined
            $this->ttl = 0;
        }
        else
        {
            $this->ttl = -1;
        }
    }

    /**
     * returns src for resource due to filemtime
     */
    protected function get_src( $output )
    {
        $path = $this->root_dir();
        //return '/' . $output ;
        return $output ;
    }

}
?>