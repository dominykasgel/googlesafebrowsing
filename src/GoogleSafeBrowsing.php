<?php namespace dominykasgel\GoogleSafeBrowsing;

class GoogleSafeBrowsing {

    private $insecure_results = [];

    /**
     * Lookup
     *
     * @param $url
     * @return array result
     *
     */
    public function lookup( $url ) {

        // Get API key
        $api_key = config( 'google_safe_browsing.api_key' );
        $client_id = config( 'google_safe_browsing.client' );

        $this->insecure_results = [
            'MALWARE' => false,
            'SOCIAL_ENGINEERING' => false,
            'UNWANTED_SOFTWARE' => false,
            "POTENTIALLY_HARMFUL_APPLICATION" => false,
        ];

        $threatTypes = [
            "MALWARE", "SOCIAL_ENGINEERING", "UNWANTED_SOFTWARE", "POTENTIALLY_HARMFUL_APPLICATION"
        ];

        $data = '{
          "client": {
            "clientId": "'. $client_id .'",
            "clientVersion": "1.0"
          },
          "threatInfo": {
            "threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING", "UNWANTED_SOFTWARE", "POTENTIALLY_HARMFUL_APPLICATION"],
            "platformTypes":    ["ALL_PLATFORMS"],
            "threatEntryTypes": ["URL"],
            "threatEntries": [
              {"url": "'. $url . '"}
            ]
          }
        }';

        $url_send = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=". $api_key ."";

        $response = $this->sendPostData( $url_send, $data );

        $response_data = json_decode( $response );

        if ( isset( $response_data->matches ) ) {
            foreach ( $response_data->matches as $site ) {

                if ( in_array($site->threatType, $threatTypes ) ) {
                    $this->insecure_results[$site->threatType] = true;
                }
            }
        }

        return $this->insecure_results;
    }

    /**
     * Get result from the url
     *
     * @param $url
     * @param $post
     *
     * @return string
     */
    private function sendPostData( $url, $post ) {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( "Content-Type: application/json", 'Content-Length: ' . strlen( $post ) ) );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_FAILONERROR, true );
        $result = curl_exec( $ch );

        return $result;
    }

    /**
     * Check if website is secure
     *
     * @return bool
     */
    public function isSecure() {
        if ( count( array_unique( $this->insecure_results ) ) === 1 && end( $this->insecure_results ) === false ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if website contains Social Engineering
     *
     * @return bool
     */
    public function isSocialEngineering() {
        return $this->insecure_results['SOCIAL_ENGINEERING'];
    }

    /**
     * Check if website contains malware
     *
     * @return bool
     */
    public function isMalware() {
        return $this->insecure_results['MALWARE'];
    }

    /**
     * Check if website contains unwanted software
     *
     * @return bool
     */
    public function isUnwanted() {
        return $this->insecure_results['UNWANTED_SOFTWARE'];
    }

    /**
     * Check if website is harmful
     *
     * @return bool
     */
    public function isHarmfulApplication() {
        return $this->insecure_results['POTENTIALLY_HARMFUL_APPLICATION'];
    }

}