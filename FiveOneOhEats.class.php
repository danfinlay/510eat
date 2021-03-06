<?php
if (!class_exists('FiveOneOhEats')) {
    
    class FiveOneOhEats {   	
    	const VERSON = '1.0';
    	

		function get_results($query, $street_name){
			$json = $this->do_curl_get_https("https://data.acgov.org/api/views/3d5b-2rnz/rows.json?search="."$query"."&max_rows=25", $headers, $returnxfer = true);
			$result_data = json_decode($json); 
			//print_r($result_data);
			$result = array();
			foreach ( $result_data->data as $row ) {
			
				$row_decoded = json_decode($row[12][0]);
				$search = sprintf("/%s/i",$street_name);
				
				$matched = preg_match($search, $row_decoded->address);
				
				
				if($matched){
					$result_line = array($row[8],$row[11],$row[9],$row_decoded);
					array_push($result,$result_line);
				}

			}
			return $result;
		}
		
		function do_curl_get_https($https_url, $headers) {

			//open connection
			$ch = curl_init();
		
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_CAINFO, NULL);
			curl_setopt($ch, CURLOPT_CAPATH, NULL);
		
			//set the url, number of POST vars, POST data
			curl_setopt($ch, CURLOPT_URL, $https_url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
			//execute post
			$result_json = curl_exec($ch);
		
			curl_close($ch);
			
			return $result_json;
		
		}	
		
		function foo() {
			return "bar";
		}	
		
    	
		
    }
        
    global $fiveoneoheats;
	$fiveoneoheats = new FiveOneOhEats();	
}
?>