
<?php
    error_reporting(E_ERROR);
    ini_set('display_errors', 'on');
    mb_internal_encoding('UTF-8');

    /* Метод init() следует вызвать один раз в начале,
    затем можно сколько угодно раз вызывать отдельные методы clean(), suggest() и т.п.
    и в конце следует один раз вызвать метод close().
    За счёт этого не создаются новые сетевые соединения на каждый запрос,
    а переиспользуется существующее. */
    //-----------------------------------------------------------
    $noNames = !$_POST['user_name'] || !$_POST['user_second_name'] || !$_POST['user_last_name'];
    if($noNames) {
        Echo json_encode(['Error' => "Заполнены не все поля разбора ФИО...", 'Detail' => ""]); 
        exit;
    }

    // ---- Стандартизовать ФИО
    $value = $_POST['user_last_name'] . " " . $_POST['user_second_name'] . " " . $_POST['user_name'];
    //---------------
    $secret = file_get_contents('security/security_dadata.txt');
    $secret = json_decode(base64_decode($secret), true);
    $dadata = new Dadata($secret['token'] , $secret['key']);
    //---------------
    $dadata->init();

    //--------------
    try {
        $result = $dadata->clean("name", $value);
        echo json_encode($result);
    }
    catch(Exception $e) {
        $errMsg = $e->getMessage();
        $errPtr = '~\{(?:[^{}]|(?R))*\}~';
        $errText = preg_replace($errPtr, '', $errMsg);
        $errJson = str_replace($errText, '', $errMsg);
        //--------------       
        echo json_encode(['Error' => $errText, 'Detail' => json_decode($errJson)]);
    }
    finally {
        $dadata->close();
    }

    /**
     * Используйте эти классы, если не умеете или не хотите работать с `composer`
     * и использовать библиотеку [dadata-php](https://github.com/hflabs/dadata-php/).
     * Классы не имеют внешних зависимостей, кроме `curl`. Примеры вызова внизу файла.
     */
    //-----------------------------------------------------------
    class TooManyRequests extends Exception
    {
    }

    //-----------------------------------------------------------
    class Dadata
    {
        private $clean_url = "https://cleaner.dadata.ru/api/v1/clean";
        private $suggest_url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs";
        private $token;
        private $secret;
        private $handle;

        //-----------------------------------------------------------
        public function __construct($token, $secret)
        {
            $this->token = $token;
            $this->secret = $secret;
        }

        //-----------------------------------------------------------
        public function init()
        {
            $this->handle = curl_init();
            //--------------
            curl_setopt($this->handle, CURLOPT_POST, 1);
            curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($this->handle, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: Token " . $this->token,
                "X-Secret: " . $this->secret,
            ));
        }

        //-------------- //--------------
        //-----------------------------------------------------------
        private function executeRequest($url, $fields)
        {
            curl_setopt($this->handle, CURLOPT_URL, $url);
            //--------------
            if ($fields != null) {
                curl_setopt($this->handle, CURLOPT_POST, 1);
                curl_setopt($this->handle, CURLOPT_POSTFIELDS, json_encode($fields));
            } else {
                curl_setopt($this->handle, CURLOPT_POST, 0);
            }
            //--------------
            $result = $this->exec();
            $result = json_decode($result, true);
            //--------------
            return $result;
        }

        //-----------------------------------------------------------
        private function exec()
        {
            $result = curl_exec($this->handle);
            $info = curl_getinfo($this->handle);
            //--------------
            if ($info['http_code'] == 429) {
                throw new TooManyRequests();
            } elseif ($info['http_code'] != 200) {
                throw new Exception('Request failed with http code ' . $info['http_code'] . ': ' . $result);
            }
            //--------------
            return $result;
        }
        //-------------- //--------------

        /**
         * Clean service.
         * See for details:
         *   - https://dadata.ru/api/clean/address
         *   - https://dadata.ru/api/clean/phone
         *   - https://dadata.ru/api/clean/passport
         *   - https://dadata.ru/api/clean/name
         * (!) This is a PAID service. Not included in free or other plans.
         */
        //-----------------------------------------------------------
        public function clean($type, $value)
        {
            $url = $this->clean_url . "/$type";
            $fields = array($value);
            //--------------
            return $this->executeRequest($url, $fields);
        }

        /**
         * Find by ID service.
         * See for details:
         *   - https://dadata.ru/api/find-party/
         *   - https://dadata.ru/api/find-bank/
         *   - https://dadata.ru/api/find-address/
         */
        //-----------------------------------------------------------
        public function findById($type, $fields)
        {
            $url = $this->suggest_url . "/findById/$type";
            //--------------
            return $this->executeRequest($url, $fields);
        }

        /**
         * Reverse geolocation service.
         * See https://dadata.ru/api/geolocate/ for details.
         */
        //-----------------------------------------------------------
        public function geolocate($lat, $lon, $count = 10, $radius_meters = 100)
        {
            $url = $this->suggest_url . "/geolocate/address";
            $fields = array(
                "lat" => $lat,
                "lon" => $lon,
                "count" => $count,
                "radius_meters" => $radius_meters
            );
            //--------------
            return $this->executeRequest($url, $fields);
        }

        /**
         * Detect city by IP service.
         * See https://dadata.ru/api/iplocate/ for details.
         */
        //-----------------------------------------------------------
        public function iplocate($ip)
        {
            $url = $this->suggest_url . "/iplocate/address";
            $fields = array(
                "ip" => $ip
            );
            //--------------
            return $this->executeRequest($url, $fields);
        }

        /**
         * Suggest service.
         * See for details:
         *   - https://dadata.ru/api/suggest/address
         *   - https://dadata.ru/api/suggest/party
         *   - https://dadata.ru/api/suggest/bank
         *   - https://dadata.ru/api/suggest/name
         *   - ...
         */
        //-----------------------------------------------------------
        public function suggest($type, $fields)
        {
            $url = $this->suggest_url . "/suggest/$type";
            //--------------
            return $this->executeRequest($url, $fields);
        }

        /**
         * Close connection.
         */
        //-----------------------------------------------------------
        public function close()
        {
            curl_close($this->handle);
        }
    }

