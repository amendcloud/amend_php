<?php 
    $IMAGE_ID = "ImageId";
    $MESSAGE = "Message";

    class Amend{
        const BASE_URL = "http://amend.cloud/";
		const FIT_XY= "fit_xy";
		const FIT_INSIDE= "fit_inside";
		const FIT_WIDTH= "fit_width";
		const FIT_FILL= "fit_fill";
    	const FIT_HEIGHT= "fit_height";
    	const FIT_FACE= "fit_face";

    	const LEFT= "left";
    	const RIGHT= "right";
    	const TOP= "top";
    	const BOTTOM= "bottom";
    	const CENTER= "center";
    	const CENTER_TOP= "center_top";

    	const NORMAL="normal";
    	const BOLD="bold";
    	const ITALIC= "italic";

    	const X= "x";
    	const Y= "y";
    	const XY= "XY";

    	const MAX= 100000;
        static $amendName="";
		static $accessKey="";
		static $accessSecret="";
		
        function config($options){
            if(isset($options['amendName'])){
                self::$amendName=$options['amendName'];
            }
			if(isset($options['accessKey'])){
                self::$accessKey=$options['accessKey'];
            }
			if(isset($options['accessSecret'])){
                self::$accessSecret=$options['accessSecret'];
            }
        }

        function load($imageName, $options){
			if(self::$amendName==""){
				echo "Amend name required";
				return;
			}
            $opt = Options::get_options($options);
            $url = self::BASE_URL.self::$amendName."/image/";
            if($opt!=""){
                $url.="/".$opt;
            }
            $url.="/".$imageName;
            $imgHTMLOptions = Options::get_html_options($options); 
            $img = '<img src="'.$url.'" '.$imgHTMLOptions.' />';
            return $img;
        }

		function fetch($imageUrl, $options){
			if(self::$amendName==""){
				echo "Amend name required";
				return;
			}
            $opt = Options::get_options($options);
            $url = self::BASE_URL.self::$amendName."/fetch/";
            if($opt!=""){
                $url.="/".$opt;
            }
            $url.="/".$imageUrl;
            $imgHTMLOptions = Options::get_html_options($options); 
            $img = '<img src="'.$url.'" '.$imgHTMLOptions.' />';
            return $img;
        }
		
		function upload($file_bytes, $name){
			if(self::$amendName==""){
				$resp = array();
				$resp['StatusCode']=400;
				$resp['Message']="Amend name required";
				return $resp;
			}
			if(self::$accessKey==""){
				$resp = array();
				$resp['StatusCode']=400;
				$resp['Message']="Amend key required";
				return $resp;
			}
			if(self::$accessSecret==""){
				$resp = array();
				$resp['StatusCode']=400;
				$resp['Message']="Amend secret required";
				return $resp;
			}
			$headerAccessKey='AccessKey:'.self::$accessKey;
			$headerAccessSecret='AccessSecret:'.self::$accessSecret;
			
            
			$base64 = base64_encode($file_bytes);
            $url = self::BASE_URL.self::$amendName.'/upload';
            $data = array('ImageBase64' => $base64, 'ImageName'=>$name);
            $data_string=json_encode($data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch,CURLOPT_VERBOSE, TRUE);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);

            curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',$headerAccessKey,$headerAccessSecret
					
            ));

            $response = curl_exec($ch);
            $resp = json_decode($response, true);
            return $resp;
		}
		
    }

    class Options{
        public function get_options($options){
            $opt = '';
            $keys=array_keys($options);
            foreach($keys as $row){
                
                switch($row){
                    case 'transform':
                        if ($opt != '') { $opt .= "/"; }
                        $opt .= Tranform::get_transform($options[$row]); 
                        break;
                    case 'quality':
                        if ($opt != '') { $opt .= "/"; }
                        $opt .= 'quality_' + $options[$row];; 
                        break;
                    case 'radius':
                        if ($opt != '') { $opt .= "/"; }
						if($options[$row]==Amend::MAX){
							$opt .= 'r_max';
						}else{
							$opt .= 'r_'.$options[$row];
						}
                        break;
                    case 'grayscale':
                        if ($opt != '') { $opt .= "/"; }
                        $opt .= 'grayscale';
                        break;
                    case 'invert':
                        if ($opt != '') { $opt .= "/"; }
                        $opt .= 'invert';
                        break;
                    case 'effect':
                        if ($opt != '') { $opt .= "/"; }
                        $opt .= Effects::get_effects($options[$row]);
                        break;
                    case 'flip':
                        if ($opt != '') { $opt .= "/"; }
                        $opt .= 'flip_'. $options[$row];
                        break;
                    case 'rotate':
                        if ($opt != '') { $opt .= "/"; }
                        $opt .= 'rotate_'.$options[$row];
                        break;
                    case 'overlay':
                        if ($opt != '') { $opt .= "/"; }
                        $opt .= Overlay::get_overlay($options[$row]);
                        break;
                }
            }
            return $opt;
        }

        public function get_html_options($options){
            $opt = '';
            $keys=array_keys($options);
            foreach($keys as $row){
                
                switch($row){
                    case 'id':
                        if ($opt != '') { $opt .= " "; }
                        $opt .= 'id = "'.$options[$row].'"'; 
                        break;
                    case 'class':
                        if ($opt != '') { $opt .= " "; }
                        $opt .= 'class = "'.implode($options[$row]," ").'"'; 
                        break;
                    case 'alt':
                        if ($opt != '') { $opt .= " "; }
                        $opt .= 'alt = "'.$options[$row].'"';
                        break;
                    case 'html_width':
                        if ($opt != '') { $opt .= " "; }
                        $opt .= 'width = "'.$options[$row].'"';
                        break;
                    case 'html_height':
                        if ($opt != '') { $opt .= " "; }
                        $opt .= 'height = "'.$options[$row].'"';
                        break;
                }
            }
            return $opt;
        }
    }


    class Tranform{
        
        public function get_transform($options){
            $opt = '';
            $keys=array_keys($options);
            foreach($keys as $row){
                
                switch($row){  
                    case 'width':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= "w_". $options[$row];
                        break;
                    case 'height':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= "h_". $options[$row];
                        break;
                    case 'align':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= "align_". $options[$row];
                        break;
                    case 'color':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= "c_". $options[$row];
                        break;
                    case 'fit':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= $options[$row];
                        break;
                    case 'color':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= "c_". $options[$row];
                        break;
                    case 'x':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= 'x_'. $options[$row];
                        break;
                    case 'y':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= 'y_'. $options[$row];
                        break;
                    }
                }
            return $opt;
        }

        function check_options($opt){
            if ($opt!="") {
                $opt .= ",";
            }
            return $opt;
        }
    }

    class Effects{
        
        public function get_effects($options){
            $opt = '';
            $keys=array_keys($options);
            foreach($keys as $row){
                if ($opt != '') { $opt .= ","; }
                switch($row){  
                    case 'brightness': 
                        $opt .= "bright_". $options[$row];
                        break;
                    case 'contrast':
                        $opt .= "contrast_". $options[$row];
                        break;
                }
            }
            return $opt;
        }

        function check_options($opt){
            if ($opt!="") {
                $opt .= ",";
            }
            return $opt;
        }
    } 

    class Overlay{
        public function get_overlay($options){
            $opt = '';
            $keys=array_keys($options);
            foreach($keys as $row){
                
                switch($row){  
                    
                    case 'image':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= 'oi-'. $options[$row];
                        break;
                    case 'text':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= 'ot-'. $options[$row];
                        break;
                    case 'size':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= 'size_'. $options[$row];
                        break;
                    case 'style':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= 'style_'. $options[$row];
                        break;
                    case 'color':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= 'c_'. $options[$row];
                        break;
                    case 'x':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= 'x_'. $options[$row];
                        break;
                    case 'y':
                        if ($opt != '') { $opt .= ","; }
                        $opt .= 'y_'. $options[$row];
                        break;
                }
            }
            return $opt;
        }
    }
    
    

?>