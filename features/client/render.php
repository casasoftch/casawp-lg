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
    }

    function registerScriptsAndStyles() {
        wp_enqueue_script('google_maps_v3', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBOPYZoLRaPFSg5JVwr7Le06qPpWd5jCU8&libraries=places', array(), false, true );
    }


    function render_clg_form($atts = array()){
        /*$a = shortcode_atts( array(
            'unit_id' => ''
        ), $atts );*/
        $a = shortcode_atts( array(
            'direct_recipient_email' => false,
        ), $atts );

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
    //	die(print_r($formData));

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

                    $this->prepareData($formData);
                    die();
                    $casamail_msgs = $this->sendCasamail(false, false, $inquiry, $formData);
                    if ($casamail_msgs) {
                        $msg .= 'CASAMAIL Fehler: '. print_r($casamail_msgs, true);
                        $state = 'danger';
                    }

                    do_action('clg_after_inquirysend', $formData);

                    //empty form
                    $formData = $this->getFormData(true);

                    


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

        print_r($formData);
        die();
        
        $fullData = [
            "countryCode" => ($formData['Land'] ? $formData['Land'] : null),
            "categoryCode" => ($formData['Objektart'] ? $formData['Objektart'] : null),
            "culture" => ($formData['culture'] ? $formData['culture'] : null),
            "externalKey" => ($formData['externalKey'] ? $formData['externalKey'] : null),
            "latitude" => ($formData['latitude'] ? $formData['latitude'] : 0),
            "longitude" => ($formData['longitude'] ? $formData['longitude'] : 0),
            "surfaceLiving" => ($formData['Nettowohnfläche'] ? $formData['Nettowohnfläche'] : 0),
            "surfaceGround" => ($formData['Grundstücksfläche'] ? $formData['Grundstücksfläche'] : 0),
            "roomNb" => ($formData['roomNb'] ? $formData['roomNb'] : 0),
            "bathNb" => ($formData['bathNb'] ? $formData['bathNb'] : 0),
            "buildYear" => ($formData['buildYear'] ? $formData['buildYear'] : 0),
            "name" => ($formData['name'] ? $formData['name'] : null),
            "surname" => ($formData['surname'] ? $formData['surname'] : null),
            "sale" => ($formData['sale'] ? $formData['sale'] : false),
            "purchase" => ($formData['purchase'] ? $formData['purchase'] : false),
            "financing" => ($formData['financing'] ? $formData['financing'] : false),
            "other" => ($formData['other'] ? $formData['other'] : false),
            "email" => ($formData['email'] ? $formData['email'] : null),
            "mobile" => ($formData['mobile'] ? $formData['mobile'] : null),
        ];

        // matchingData
        $matchingData = [];
        // match categoryCode
        switch ($fullData['categoryCode']) {
            case 'Einfamilienhaus':
                $requestData['categoryCode'] = 5;
                break;
            case 'Eigentumswohnung':
                $requestData['categoryCode'] = 6;
                break;
            default:
                break;
        }
    }

    private function createIaziEvaluation() {
        




        $LicenseKey = '3FA5CA0FAC524008A16A4A91C3F473829C1FE75877514A17AA168F64FA10CD80';
        $Salt = 'de7a3576-b0f8-4dc4-8aa2-99df4c91c94d-34c6cc8a-7940-4561-99c6-3baf3e237f33';
        $RecaptchaSiteKey = '6LdEPXEUAAAAAFmTE5tfxTTT42SZuarZcK1kLHvp';

        

        $testUrl = "https://testservices.iazi.ch/api/hedolight/v1/evaluationResult";
        $liveUrl = "https://api.iazi.ch/api/hedolight";

        $curl = curl_init();

        curl_setopt_array(
            $curl, 
            [
                CURLOPT_URL => $testUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => [
                    "cache-control: no-cache"
                ],
            ]
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

}



// Subscribe to the drop-in to the initialization event
add_action( 'casawplg_init', array( 'casasoft\casawplg\render', 'init' ) );
