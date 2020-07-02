<?php
namespace casasoft\casawplg;

/*
    provider/publisher/directmail -> CASAMAIL is given
    IAZI option needs to be added for providing License Key given from IAZI to identify customer and their config
*/


class render extends Feature {
    
    

    public function __construct() {
        //$this->add_action( 'init', 'set_shortcodes' );
        $this->fieldMessages = array(
            'first_name' => __('First name is required', 'casawplg'),
            'last_name' => __('Last name is required', 'casawplg'),
            'legal_name' => __('The company is required', 'casawplg'),
            'email' => __('Email is not valid', 'casawplg'),
            'phone' => __('A phone number is required', 'casawplg'),
            'street' => __('A street address is required', 'casawplg'),
            'postal_code' => __('ZIP is required', 'casawplg'),
            'locality' =>  __('City is required', 'casawplg'),
            'message' => __('Message is required', 'casawplg'),
            'post' => __('Ivalid post', 'casawplg'),
            'gender' => 'That should not be possible',
            'unit_id' => __('Please choose a unit', 'casawplg'),//'Bitte wählen Sie eine Wohnung'
        );
        
        add_shortcode( 'CLG-form', [$this, 'render_clg_form'] );
        add_action('wp_enqueue_scripts', array($this, 'registerScriptsAndStyles'));

        $this->LicenseKey = $this->get_option("iazievaluation_key"); // this needs to be coming from options
        $this->Salt = 'de7a3576-b0f8-4dc4-8aa2-99df4c91c94d-34c6cc8a-7940-4561-99c6-3baf3e237f33';
        $this->RecaptchaSiteKey = '6LdEPXEUAAAAAFmTE5tfxTTT42SZuarZcK1kLHvp';
        $this->alg = 'SHA-512';
        $this->enc = 'B64';
        $this->encInit = 'TEXT';
    }

    function registerScriptsAndStyles() {
        $lang = substr(get_bloginfo('language'), 0, 2);

        wp_register_script('google_maps_v3', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyACeY96O194ywiXvns2lLcSp15e6VcBQBg&libraries=places&language='.$lang, array(), false, true );
        wp_register_script('recaptcha', 'https://www.google.com/recaptcha/api.js?hl='.$lang, array(), false, true );

        wp_enqueue_style( 'casawp-lg-front', PLUGIN_URL . 'assets/css/casawp-lg-front.css', array(), '1', 'screen' );
        wp_register_script( 'casawp-lg-front', PLUGIN_URL . 'assets/js/casawp-lg-front.min.js', array('jquery'), '3');
        wp_register_script( 'moment', PLUGIN_URL . 'assets/js/moment.min.js');
    }


    function render_clg_form($atts = array()){
        /*$a = shortcode_atts( array(
            'unit_id' => ''
        ), $atts );*/
        
        $a = shortcode_atts( array(
            'direct_recipient_email' => false,
        ), $atts );

        wp_enqueue_script('google_maps_v3');
        wp_enqueue_script('recaptcha');
        wp_enqueue_script('casawp-lg-front');
        wp_enqueue_script('moment');

        return $this->renderForm($atts);

    }


    private $formLoaded = false;
    public function isFormLoaded() {
        return $this->formLoaded;
    }
    public function setFormLoaded() {
        $this->formLoaded = true;
    }


    private function storeInquiry($args, $formData) {
        $inq_post_id = wp_insert_post( $args );
        if ($inq_post_id) {
            foreach ($formData as $key => $value) {
                add_post_meta( $inq_post_id, '_casawplg_inquiry_'.$key, $value , true);
            }
        }
        return get_post($inq_post_id);
    }

    public function renderForm($args) {

        $template = $this->get_template();
        
        $formData =  $this->getFormData();
        //  die(print_r($formData));
        
        $msg = '';
        $state = '';
        $messages = array();
        if ($formData['post']) {
            if ($this->formValid()) {
                if (wp_verify_nonce($_REQUEST['_wpnonce'], 'send-inquiry')) {
                    $msg = __('Inquiry has been sent. Thank you!', 'casawplg');
                    $state = 'success';

                    $inq_post = array(
                        'post_content'   => '',
                        'post_title'     => $formData['first_name'] . ' ' . $formData['last_name'],
                        'post_status'    => 'publish',
                        'post_type'      => 'casawplg_inquiry',
                        'ping_status'    => 'closed',
                        'comment_status' => 'closed',
                    );

                    do_action('clg_before_inquirystore', $formData);

                    $inquiry = $this->storeInquiry($inq_post, $formData);

                    do_action('clg_before_inquirysend', $formData);

                    $validCaptcha = null;
                    // print_r($formData);
                    if ($this->LicenseKey) { // needs the option what to send
                        if (isset($formData['captcha_response'])) {
                            $validCaptcha = $this->verifyIaziCaptcha($formData['captcha_response']);
                        }
                        if ($validCaptcha &&  $validCaptcha === 'success') {
                            $preparedData = $this->prepareData($formData);
                           
                                $iaziEvaluationResponse = $this->sendIAZIEvaluation($preparedData);
                                // print_r($iaziEvaluationResponse);
                                // die();
                                if ($iaziEvaluationResponse == 'success') {
                                    do_action('clg_after_inquirysend', $formData);
                        
                                    //empty form
                                    $formData = $this->getFormData(true);
                                } else {
                                    echo ('There was an error with sending the Mail');
                                    print_r($iaziEvaluationResponse);
                                }
                           
                        } else {
                            print('There was an error with captcha');
                        }
                    } else {
                        $casamail_msgs = $this->sendCasamail(false, false, $inquiry, $formData);
                        if ($casamail_msgs) {
                            $msg .= 'CASAMAIL Fehler: '. print_r($casamail_msgs, true);
                            $state = 'danger';
                        }
                        
                        do_action('clg_after_inquirysend', $formData);
                    
                        //empty form
                        $formData = $this->getFormData(true);
                    }
                }
            } else {
                $msg = __('Please check the following and try again:', 'casawplg');
                $msg .= '<ul>';
                foreach ($this->getFormMessages() as $col => $message) {
                    $msg .= '<li>' . $message . '</li>';
                }
                $msg .= '</ul>';
                $state = 'danger';
                $messages = $this->getFormMessages();
            }

        }
        $template->set('messages', $messages);
        $template->set('message', $msg);
        $template->set('state', $state);
        $template->set('data', $formData);
        $message = $template->apply( 'form.php' );
        return $message;
        
    }


    public function getFormData($empty = false) {
        
        $defaults_inq = get_default_clg('inquiry', false);

        $defaults = array();
        foreach ($defaults_inq as $key => $inq_item) {
            $defaults[$key] = $inq_item['value'];
        }
        $defaults['post'] = 0;

        $request = array();
        if (!$empty) {
            $request = array_merge($_GET, $_POST);
        }

        
        if (isset($request['casawplg-inquiry'])) {
            $formData = array_merge($defaults, $request['casawplg-inquiry']);
        } else {
            $formData = $defaults;
        }
        if (isset($request['extra_data'])) {
            $formData['extra_data'] = $request['extra_data'];
        }

        if (isset($request['g-recaptcha-response'])) {
            $formData['captcha_response'] = $request['g-recaptcha-response'];
        }

        if (isset($request['auth'])) {
            $this->auth = $request['auth'];
        }



        return $formData;
    }

    public $fieldMessages = array();
    public function addFieldValidationMessage($col, $message) {
        $this->fieldMessages = $fieldMessages;
        $this->fieldMessages[$col] = $message;
    }
    public $requiredFields = array(
        'first_name',
        'last_name',
        'phone',
        'street',
        'postal_code',
        'locality'
    );
    public function setFieldRequired($col) {
        $this->requiredFields[] = $col;
    }

    public function getFormMessages() {
        
        $defaults = $this->fieldMessages;
        $messagesReturn = apply_filters('clg_filter_form_required_messages', array("messages" => $this->fieldMessages, "formData" => $this->getFormData()));
        if ($messagesReturn && is_array($messagesReturn)) {
            $defaults = $messagesReturn["messages"];
        }

        $required = $this->requiredFields;
        $requiredReturn = apply_filters('clg_filter_form_required', array("fields" => $this->requiredFields, "formData" => $this->getFormData()));
        if ($requiredReturn && is_array($requiredReturn)) {
            $required = $requiredReturn["fields"];
        }

        $messages = array();
        foreach ($this->getFormData() as $col => $value) {
            if (in_array($col, $required)) {
                if (!$value || $value == '–') {
                    if (isset($defaults[$col])) {
                        $messages[$col] = $defaults[$col];
                    } else {
                        $messages[$col] = $col . ' required';
                    }

                }
            } else {
                switch ($col) {
                    case 'email':
                        $valid = filter_var($value, FILTER_VALIDATE_EMAIL);
                        if (! $valid) {
                            $messages[$col] = $defaults[$col];
                        }
                        break;
                    case 'post':
                        if (! $value) {
                            //silent but deadly
                            $messages[$col] = 'Your message has been sent!?';
                        }
                        break;

                }
            }
        }
        $returndata = apply_filters('clg_filter_form_messages', array("messages" => $messages, "formData" => $this->getFormData()));

        if (is_array($returndata)) {
            if (isset($returndata['messages'])) {
                $returndata = $returndata['messages'];
            }
            $messages = $returndata;
        }

        return $messages;
    }

    public function formValid() {
        if (count($this->getFormMessages())) {
            return false;
        }
        return true;
    }


    public function sendCasamail($provider = false, $publisher = false, $inquiry, $formData) {
        if (! $provider) {
            $provider = $this->get_option("provider_slug");
        }
        if (! $publisher) {
            $publisher = $this->get_option("publisher_slug");
        }
        if ($provider && $publisher) {
            $lang = substr(get_bloginfo('language'), 0, 2);

            //CASAMAIL
            $data                = array();
            $data['firstname']   = get_clg($inquiry->ID, 'first_name');
            $data['lastname']    = get_clg($inquiry->ID, 'last_name');
            $gender = get_clg($inquiry->ID, 'gender');
            if ($gender == 'female') {
                $data['gender']      = 2;
            } elseif ($gender == 'male') {
                $data['gender']      = 1;
            }
            //$data['country']     = 'CH';
            $data['mobile']       = get_clg($inquiry->ID, 'mobile');
            //$data['mobile']       = '000 000 00 00';
            //$data['fax']       = '000 000 00 00';
            $data['email']       = get_clg($inquiry->ID, 'email');

            $data['provider']               = $provider; //must be registered at CASAMAIL
            $data['publisher']              = $publisher; //must be registered at CASAMAIL
            $data['lang']                   = $lang;
            //$data['property_street']        = 'musterstrasse 17';
            //$data['property_postal_code']   = '3291';
            //$data['property_locality']      = 'Ortschaft';
            //$data['property_category']      = 'house';
            //$data['property_country']       = 'CH';
            //$data['property_rooms']         = '3.2';
            //$data['property_type']          = 'rent';
            //$data['property_price']         = '123456';
            $data['direct_recipient_email'] = $this->get_option("global_direct_recipient_email");

            $extra_data = array();

            //custom extra data
            if (isset($formData['extra_data'])) {
                foreach ($formData['extra_data'] as $key => $value) {
                    $extra_data[$key] = $value;
                }
            }

            $data['extra_data'] = json_encode($extra_data);

            $returndata = apply_filters('clg_filter_casamail_data', $data, $formData);
            if ($returndata) {
                $data = $returndata;
            }

            $data_string = json_encode($data);

            $ch = curl_init('http://onemail.ch/api/msg');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
            );
            curl_setopt($ch, CURLOPT_USERPWD,  "matchcom:bbYzzYEBmZJ9BDumrqPKBHM");

            $result = curl_exec($ch);
            $json = json_decode($result, true);
            if (isset($json['validation_messages'])) {
                return $json['validation_messages'];
            } else {
                return null;
            }
        }
    }

    private function prepareData($formData) {
        /*
            Array[
                UserEvaluationInput {
                    countryCode (string, optional),
                    categoryCode (integer, optional),
                    culture (string, optional),
                    externalKey (string, optional),
                    latitude (number, optional),
                    longitude (number, optional),
                    surfaceLiving (number, optional),
                    surfaceGround (number, optional),
                    roomNb (number, optional),
                    bathNb (integer, optional),
                    buildYear (integer, optional),
                    name (string, optional),
                    surname (string, optional),
                    sale (boolean, optional),
                    purchase (boolean, optional),
                    financing (boolean, optional),
                    other (boolean, optional),
                    email (string, optional),
                    mobile (string, optional)
                }
            ]
        */

        // print_r($formData);
        // die();
        
        $fullData = [
            "name" => ($formData['first_name'] ? $formData['first_name'] : null),
            "surname" => ($formData['last_name'] ? $formData['last_name'] : null),
            "culture" => 'de-CH',
            "email" => ($formData['email'] ? $formData['email'] : null),
            "mobile" => ($formData['mobile'] ? $formData['mobile'] : null),
            "message" => ($formData['message'] ? $formData['message'] : null),
            "gender" => ($formData['gender'] ? $formData['gender'] : null),
            "categoryCode" => ($formData['extra_data']['propertyType'] ? $formData['extra_data']['propertyType'] : null),
            "countryCode" => ($formData['extra_data']['country'] ? $formData['extra_data']['country'] : null),
            "latitude" => ($formData['extra_data']['lat'] ? $formData['extra_data']['lat'] : 0),
            "longitude" => ($formData['extra_data']['lng'] ? $formData['extra_data']['lng'] : 0),
            "formattedAddress" => ($formData['extra_data']['formattedAddress'] ? $formData['extra_data']['formattedAddress'] : 0),
            "surfaceLiving" => ($formData['extra_data']['areaNwf'] ? $formData['extra_data']['areaNwf'] : 0),
            "surfaceGround" => ($formData['extra_data']['areaPropertyLand'] ? $formData['extra_data']['areaPropertyLand'] : 0),
            "roomNb" => ($formData['extra_data']['numberOfRooms'] ? $formData['extra_data']['numberOfRooms'] : 0),
            "bathNb" => ($formData['extra_data']['numberOfBathrooms'] ? $formData['extra_data']['numberOfBathrooms'] : 0),
            "buildYear" => ($formData['extra_data']['yearBuilt'] ? $formData['extra_data']['yearBuilt'] : 0),
            "sale" => ($formData['extra_data']['sell'] ? 1 : 0),
            "purchase" => ($formData['extra_data']['buy'] ? 1 : 0),
            "financing" => ($formData['extra_data']['financing'] ? 1 : 0),
            "other" => ($formData['extra_data']['other'] ? 1 : 0),
        ];

        // prepareData
        $prepareData = [];

        // match categoryCode
        switch ($fullData['categoryCode']) {
            case 'single-family-house':
                $prepareData['categoryCode'] = 5;
                break;
            case 'flat':
                $prepareData['categoryCode'] = 6;
                break;
            default:
                break;
        }

        // external Key
        $provider = $this->get_option("provider_slug");
        $publisher = $this->get_option("publisher_slug");
        $time = time();

        $prepareData['externalKey'] = ($provider ? $provider . '_' : '') . ($publisher ? $publisher . '_' : '') . $time;
        $prepareData['name'] = $fullData['name'];
        $prepareData['surname'] = $fullData['surname'];
        $prepareData['culture'] = $fullData['culture'];
        $prepareData['email'] = $fullData['email'];
        $prepareData['mobile'] = $fullData['mobile'];
        $prepareData['message'] = $fullData['message'];
        $prepareData['gender'] = $fullData['gender'];
        $prepareData['countryCode'] = $fullData['countryCode'];
        $prepareData['latitude'] = $fullData['latitude'];
        $prepareData['longitude'] = $fullData['longitude'];
        $prepareData['formattedAddress'] = $fullData['formattedAddress'];
        $prepareData['surfaceLiving'] = $fullData['surfaceLiving'];
        $prepareData['sale'] = $fullData['sale'];
        $prepareData['purchase'] = $fullData['purchase'];
        $prepareData['financing'] = $fullData['financing'];
        $prepareData['other'] = $fullData['other'];
        $prepareData['roomNb'] = $fullData['roomNb'];
        $prepareData['buildYear'] = $fullData['buildYear'];

        if ($prepareData['categoryCode'] == 5 ) {
            // Einfamilienhaus
            $prepareData['surfaceGround'] = $fullData['surfaceGround'];
        } else {
            // Eigentumswohnung
            $prepareData['bathNb'] = $fullData['bathNb'];
        }
        
        // language
        $lang = substr(get_bloginfo('language'), 0, 2);
        switch ($lang) {
            case 'de':
                $prepareData['culture'] = 'de-CH';
                break;
            case 'fr':
                $prepareData['culture'] = 'fr-CH';
                break;
            case 'it':
                $prepareData['culture'] = 'it-CH';
                break;
            case 'en':
                $prepareData['culture'] = 'en-US';
                break;
            default:
                $prepareData['culture'] = 'de-CH';
                break;
        }
        
        // print_r($prepareData);
        // die();
        return $prepareData;
    }

    private function sendIAZIEvaluation($requestData) {
        // print_r($requestData);
        $body = json_encode([$requestData], true);

        $testUrl = "https://testservices.iazi.ch/api/hedolight/v1/evaluationResult";
        $liveUrl = "https://api.iazi.ch/api/hedolight/v1/evaluationResult";

        $x = $this->LicenseKey;
        $t = time();
        $z = $this->Salt;
        $hash = base64_encode(hash('sha512', $x.$t.$z, true));
        $curl = curl_init();
        if ($this->get_option("iazikey_url")) {
            $thisUrl = $this->get_option("iazikey_url");
        } else {
            $thisUrl = get_site_url();
        }
        curl_setopt_array(
            $curl, 
            [
                CURLOPT_URL => $liveUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_REFERER => $thisUrl,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "cache-control: no-cache",
                    "t: $t",
                    "x: $x",
                    "h: $hash"
                ],
            ]
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $decodedResponse = json_decode($response, true);
            if ($decodedResponse == 'Mail Sent!') {
                return 'success';
            } else {
                return false;
            }
        }
    }

    private function verifyIaziCaptcha($captchaResponse) {
        $x = $this->LicenseKey;
        $t = time();
        $z = $this->Salt;
        $curl = curl_init();
        $hash = base64_encode(hash('sha512', $x.$t.$z, true));
        $testUrl = "https://testapi.iazi.ch/api/hedolight/v1/verifyCaptcha";
        $liveUrl = "https://api.iazi.ch/api/hedolight/v1/verifyCaptcha";
        $query = '?response='.$captchaResponse;

        //die($query);
        if ($this->get_option("iazikey_url")) {
            $thisUrl = $this->get_option("iazikey_url");
        } else {
            $thisUrl = get_site_url();
        }
        //die($x);
        curl_setopt_array(
            $curl, 
            [
                CURLOPT_URL => $liveUrl.$query,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                // CURLOPT_POSTFIELDS => $body,
                CURLOPT_REFERER => $thisUrl,
                CURLOPT_HTTPHEADER => [
                    "cache-control: no-cache",
                    "t: $t",
                    "x: $x",
                    "h: $hash"
                ],
            ]
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
       // die($response);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $decodedResponse = json_decode($response, true);
     /*       print_r($decodedResponse);
            die();*/
            if ($decodedResponse['success']) {
                return 'success';
            } else {
                return false;
            }
        }
    }

}



// Subscribe to the drop-in to the initialization event
add_action( 'casawplg_init', array( 'casasoft\casawplg\render', 'init' ) );
