<?php

// Automated configuration. Modify these if they fail. (they shouldn't ;) )
$GLOBALS['WKPDF_PATH']='/bin/wkhtmltopdf';

/**
 * @author Christian Sciberras
 * @see <a href="http://code.google.com/p/wkhtmltopdf/">http://code.google.com/p/wkhtmltopdf/</a>
 * @copyright 2010 Christian Sciberras / Covac Software.
 * @license None. There are no restrictions on use, however keep copyright intact.
 *   Modification is allowed, keep track of modifications below in this comment block.
 * @example
 *   <font color="#008800"><i>//-- Create sample PDF and embed in browser. --//</i></font><br>
 *   <br>
 *   <font color="#008800"><i>// Include WKPDF class.</i></font><br>
 *   <font color="#0000FF">require_once</font>(<font color="#FF0000">'wkhtmltopdf/wkhtmltopdf.php'</font>);<br>
 *   <font color="#008800"><i>// Create PDF object.</i></font><br>
 *   <font color="#EE00EE">$pdf</font>=new <b>WKPDF</b>();<br>
 *   <font color="#008800"><i>// Set PDF's HTML</i></font><br>
 *   <font color="#EE00EE">$pdf</font>-><font color="#0000FF">set_html</font>(<font color="#FF0000">'Hello &lt;b&gt;Mars&lt;/b&gt;!'</font>);<br>
 *   <font color="#008800"><i>// Convert HTML to PDF</i></font><br>
 *   <font color="#EE00EE">$pdf</font>-><font color="#0000FF">render</font>();<br>
 *   <font color="#008800"><i>// Output PDF. The file name is suggested to the browser.</i></font><br>
 *   <font color="#EE00EE">$pdf</font>-><font color="#0000FF">output</font>(<b>WKPDF</b>::<font color="#EE00EE">$PDF_EMBEDDED</font>,<font color="#FF0000">'sample.pdf'</font>);<br>
 * @version
 *   0.0 Chris - Created class.<br>
 *   0.1 Chris - Variable paths fixes.<br>
 *   0.2 Chris - Better error handlng (via exceptions).<br>
 * <font color="#FF0000"><b>IMPORTANT: Make sure that there is a folder in %LIBRARY_PATH%/tmp that is writable!</b></font>
 * <br><br>
 * <b>Features/Bugs/Contact</b><br>
 * Found a bug? Want a modification? Contact me at <a href="mailto:uuf6429@gmail.com">uuf6429@gmail.com</a> or <a href="mailto:contact@covac-software.com">contact@covac-software.com</a>...
 *   guaranteed to get a reply within 2 hours at most (daytime GMT+1).
 */
class WKPDF {
        /**
         * Private use variables.
         */
        private $html='';
        private $cmd='';
        private $tmp='';
        private $pdf='';
        private $status='';
        private $orient='Portrait';
        private $size='A4';
        private $toc=false;
        private $copies=1;
        private $grayscale=false;
        private $title='';
        private static $cpu='';
        /**
         * Advanced execution routine.
         * @param string $cmd The command to execute.
         * @param string $input Any input not in arguments.
         * @return array An array of execution data; stdout, stderr and return "error" code.
         */
        private static function _pipeExec($cmd,$input=''){
                $proc=proc_open($cmd,array(0=>array('pipe','r'),1=>array('pipe','w'),2=>array('pipe','w')),$pipes);
                fwrite($pipes[0],$input);
                fclose($pipes[0]);
                $stdout=stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                $stderr=stream_get_contents($pipes[2]);
                fclose($pipes[2]);
                $rtn=proc_close($proc);
                return array(
                                'stdout'=>$stdout,
                                'stderr'=>$stderr,
                                'return'=>$rtn
                        );
        }

        /**
         * PDF file is saved into the server space when finish() is called. The path is returned.
         */
        public static $PDF_SAVEFILE='F';
        /**
         * PDF generated as landscape (vertical).
         */
        public static $PDF_PORTRAIT='Portrait';
        /**
         * PDF generated as landscape (horizontal).
         */
        public static $PDF_LANDSCAPE='Landscape';

        /**
         * Constructor: initialize command line and reserve temporary file.
         */
        public function __construct($cmd = null){
                $this->cmd=$cmd ? $cmd : $GLOBALS['WKPDF_PATH'];
                if(!file_exists($this->cmd)) {
                        throw new Exception('WKPDF static executable "'.htmlspecialchars($this->cmd).'" was not found.');
                }
        }
        /**
         * Set orientation, use constants from this class.
         * By default orientation is portrait.
         * @param string $mode Use constants from this class.
         */
        public function set_orientation($mode){
                $this->orient=$mode;
        }
        /**
         * Set page/paper size.
         * By default page size is A4.
         * @param string $size Formal paper size (eg; A4, letter...)
         */
        public function set_page_size($size){
                $this->size=$size;
        }
        /**
         * Whether to automatically generate a TOC (table of contents) or not.
         * By default TOC is disabled.
         * @param boolean $enabled True use TOC, false disable TOC.
         */
        public function set_toc($enabled){
                $this->toc=$enabled;
        }
        /**
         * Set the number of copies to be printed.
         * By default it is one.
         * @param integer $count Number of page copies.
         */
        public function set_copies($count){
                $this->copies=$count;
        }
        /**
         * Whether to print in grayscale or not.
         * By default it is OFF.
         * @param boolean True to print in grayscale, false in full color.
         */
        public function set_grayscale($mode){
                $this->grayscale=$mode;
        }
        /**
         * Set PDF title. If empty, HTML <title> of first document is used.
         * By default it is empty.
         * @param string Title text.
         */
        public function set_title($text){
                $this->title=$text;
        }

        public function set_html_path($path){
                $this->path=$path;
        }
        /**
         * Returns WKPDF print status.
         * @return string WPDF print status.
         */
        public function get_status(){
                return $this->status;
        }
        /**
         * Attempts to return the library's full help.
         * @return string WKHTMLTOPDF HTML help.
         */
        public function get_help(){
                $tmp=self::_pipeExec('"'.$this->cmd.'" --extended-help');
                return $tmp['stdout'];
        }
        /**
         * Convert HTML to PDF.
         */
        public function output($file){
                $cmd = '"'.$this->cmd.'"'
                        .(($this->copies>1)?' --copies '.$this->copies:'')     // number of copies
                        .' --orientation '.$this->orient                       // orientation
                        .' --page-size '.$this->size                           // page size
                        .($this->toc?' --toc':'')                              // table of contents
                        .($this->grayscale?' --grayscale':'')                  // grayscale
                        .(($this->title!='')?' --title "'.$this->title.'"':'') // title
                        .' "'.$this->path.'" -';                               // URL and optional to write to STDOUT
                $this->pdf=self::_pipeExec($cmd);
                if(strpos(strtolower($this->pdf['stderr']),'error')!==false) throw new Exception('WKPDF system error: <pre>'.$this->pdf['stderr']." for $cmd</pre>");
                if($this->pdf['stdout']=='')throw new Exception('WKPDF didn\'t return any data. <pre>'.$this->pdf['stderr']." for $cmd</pre>");
                if(((int)$this->pdf['return'])>1)throw new Exception('WKPDF shell error, return code '.(int)$this->pdf['return']." for $cmd.");
                $this->status=$this->pdf['stderr'];
                return file_put_contents($file, $this->pdf['stdout']);
        }
}