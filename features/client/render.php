<?php
namespace casasoft\casawplg;


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
		$this->add_action( 'clg_render_home_icons', 'clg_render_home_icons', 10 );
		$this->add_action( 'clg_render_contactform', 'clg_render_contactform', 10 );
		$this->add_action( 'clg_render_property_data', 'clg_render_property_data', 10 );
		$this->add_action( 'clg_render_map', 'clg_render_map', 10 );
		$this->add_action( 'clg_render_primary_start_button', 'clg_render_primary_start_button', 10 );
		$this->add_action( 'clg_render_primary_forward_button', 'clg_render_primary_forward_button', 10 );
		$this->add_action( 'clg_render_primary_back_button', 'clg_render_primary_back_button', 10 );
		$this->add_action( 'clg_render_primary_submit_button', 'clg_render_primary_submit_button', 10 );
		$this->add_action( 'clg_render_counter', 'clg_render_counter', 10 );
		$this->add_action( 'clg_render_contentpart_one', 'clg_render_contentpart_one', 10 );
		$this->add_action( 'clg_render_contentpart_two', 'clg_render_contentpart_two', 10 );
		$this->add_action( 'clg_render_contentpart_three', 'clg_render_contentpart_three', 10 );
		$this->add_action( 'clg_render_contentpart_four', 'clg_render_contentpart_four', 10 );
		add_action('wp_enqueue_scripts', array($this, 'registerScriptsAndStyles'));
	}

	function registerScriptsAndStyles(){
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

	
	public function clg_render_home_icons(){
	    ?>
	        <div class="casawp-lg_slideinner__icons">
	            <div>
	                <span class="icons_iconouter__first">
	                    <svg width="20px" height="24px" viewBox="0 0 20 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
	                            <g class="strokeColor" transform="translate(-605.000000, -521.000000)" stroke="#ffffff">
	                                <g transform="translate(600.000000, 518.000000)">
	                                    <g transform="translate(6.000000, 4.000000)">
	                                        <path d="M17.5263158,9.47368421 C17.5263158,16.1052632 9,22.2631579 9,22.2631579 C9,22.2631579 0.473684211,16.1052632 0.473684211,9.47368421 C0.473684211,4.50378947 4.02915789,0.473684211 9,0.473684211 C13.9698947,0.473684211 17.5263158,4.50378947 17.5263158,9.47368421 L17.5263158,9.47368421 Z"></path>
	                                        <polyline points="6.15789474 8.05263158 6.15789474 12.7894737 11.8421053 12.7894737 11.8421053 8.05263158"></polyline>
	                                        <polygon points="4.26315789 8.05263158 9 3.78947368 13.7368421 8.05263158"></polygon>
	                                        <polygon points="8.05263158 12.7894737 9.94736842 12.7894737 9.94736842 9.94736842 8.05263158 9.94736842"></polygon>
	                                    </g>
	                                </g>
	                            </g>
	                        </g>
	                    </svg>
	                </span>
	            </div>
	            <div>
	                <span class="icons_iconouter__second">
	                    <svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linejoin="round">
	                            <g class="strokeColor" transform="translate(-675.000000, -524.000000)" stroke="#ffffff">
	                                <g transform="translate(670.000000, 518.000000)">
	                                    <g transform="translate(6.000000, 6.000000)">
	                                        <polyline stroke-linecap="round" points="2.625 9.375 2.625 16.875 15.375 16.875 15.375 9.75"></polyline>
	                                        <polyline stroke-linecap="round" points="0.375 9 9 0.375 17.625 9"></polyline>
	                                        <polyline stroke-linecap="round" points="12 1.125 14.625 1.125 14.625 3.75"></polyline>
	                                        <path d="M12.75,9.832425 C12.75,11.789925 9.585,14.144925 9.2175,14.407425 C9.1575,14.459925 9.075,14.482425 9,14.482425 C8.925,14.482425 8.8425,14.459925 8.7825,14.407425 C8.415,14.144925 5.25,11.789925 5.25,9.832425 C5.25,8.437425 6.2925,7.597425 7.2975,7.597425 C7.875,7.597425 8.55,7.882425 9,8.624925 C9.45,7.882425 10.125,7.597425 10.7025,7.597425 C11.7075,7.597425 12.75,8.437425 12.75,9.832425 L12.75,9.832425 Z"></path>
	                                    </g>
	                                </g>
	                            </g>
	                        </g>
	                    </svg>
	                </span>
	            </div>
	            <div>
	                <span class="icons_iconouter__third">
	                    <svg width="20px" height="20px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linejoin="round">
	                            <g class="strokeColor" transform="translate(-745.000000, -522.000000)" stroke="#ffffff">
	                                <g transform="translate(740.000000, 518.000000)">
	                                    <g transform="translate(6.000000, 5.000000)">
	                                        <path d="M6.75,10.07622 L6.75,12.59982 L2.2419,14.20992 C1.1673,14.59422 0.45,15.61212 0.45,16.75242 L0.45,18.44982 L17.55,18.44982 L17.55,16.75242 C17.55,15.61212 16.8327,14.59422 15.7581,14.20992 L11.25,12.59982 L11.25,10.07622"></path>
	                                        <path d="M13.5,5.4 C13.5,8.3817 11.4849,10.8 9,10.8 C6.5142,10.8 4.5,8.3817 4.5,5.4 C4.5,2.4183 6.5142,0 9,0 C11.4849,0 13.5,2.4183 13.5,5.4 L13.5,5.4 Z"></path>
	                                        <path d="M13.45779,4.90779 C13.30659,4.92669 13.20219,4.92039 13.05009,4.95009 C11.51739,5.24529 10.53279,4.68999 9.68859,3.21309 C9.18279,4.18329 7.59969,4.95009 6.30009,4.95009 C5.66019,4.95009 5.10939,4.81869 4.55769,4.53069"></path>
	                                    </g>
	                                </g>
	                            </g>
	                        </g>
	                    </svg>
	                </span>
	            </div>
	            <div>
	                <span class="icons_iconouter__check">
	                    <svg width="15px" height="13px" viewBox="0 0 15 13" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
	                            <g class="fillColor" transform="translate(-818.000000, -526.000000)" fill="#ffffff">
	                                <g transform="translate(810.000000, 518.000000)">
	                                    <polygon points="12.765625 17.78125 21.75 8.796875 23 10.0078125 12.765625 20.203125 8 15.4375 9.25 14.2265625"></polygon>
	                                </g>
	                            </g>
	                        </g>
	                    </svg>
	                </span>
	            </div>
	        </div>
	    <?php
	}

	public function clg_render_contactform(){
	    ?>
	        <div class="casawp-lg_contactform">
	            <div class="form-group">
	                <div class="casawp-lg_toggle">
	                    <span class="casawp-lg_spanlabel"><?php echo __('Salutation', 'theme') ?></span>
	                    <div class="casawp-lg_togglebox">
	                        <input type="radio" class="casawp-lg_togglebox__switchinput" name="casawplg-inquiry[gender]" value="Frau" id="casawp-lg-gender_woman" checked>
	                        <label for="casawp-lg-gender_woman" class="casawp-lg_togglebox__switchlabel casawp-lg_togglebox__switchlabel-off">Frau</label>
	                        <input type="radio" class="casawp-lg_togglebox__switchinput" name="casawplg-inquiry[gender]" value="Herr" id="casawp-lg-gender_man">
	                        <label for="casawp-lg-gender_man" class="casawp-lg_togglebox__switchlabel casawp-lg_togglebox__switchlabel-on">Herr</label>
	                        <span class="casawp-lg_togglebox__switchselection"></span>
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-lg-6">
	                    <div class="form-group">
	                        <label for="casawp-lg_firstname" class="control-label"><?php echo __('First name', 'theme') ?><sup>*</sup></label>
	                        <input type="text" class="form-control" required id="casawp-lg_firstname" name="casawplg-inquiry[first_name]">
	                    </div>
	                </div>
	                <div class="col-lg-6">
	                    <div class="form-group">
	                        <label for="casawp-lg_lastname" class="control-label"><?php echo __('Last name', 'theme') ?><sup>*</sup></label>
	                        <input type="text" class="form-control" required id="casawp-lg_lastname" name="casawplg-inquiry[last_name]">
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-lg-6">
	                    <div class="form-group">
	                        <label for="casawp-lg_mail" class="control-label"><?php echo __('Email', 'theme') ?><sup>*</sup></label>
	                        <input type="text" class="form-control" required id="casawp-lg_mail" name="casawplg-inquiry[email]">
	                    </div>
	                </div>
	                <div class="col-lg-6">
	                    <div class="form-group">
	                        <label for="casawp-lg_mobile" class="control-label"><?php echo __('Mobile', 'theme') ?></label>
	                        <input type="text" class="form-control" id="casawp-lg_mobile" name="casawplg-inquiry[mobile]">
	                    </div>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-lg-6">
	                    <div class="form-group">
	                        <div class="casawp-lg_radiotitle"><?php echo __('Estimation reason', 'theme') ?></div>
	                        <select name="extra_data[Bewertungsgrund]" id="casawp-lg_persontype">
	                            <option value="<?php echo __('Sell', 'theme') ?>"><?php echo __('Sell', 'theme') ?></option>
	                            <option value="<?php echo __('Buy', 'theme') ?>"><?php echo __('Buy', 'theme') ?></option>
	                            <option value="<?php echo __('Financing', 'theme') ?>"><?php echo __('Financing', 'theme') ?></option>
	                            <option value="<?php echo __('Other', 'theme') ?>"><?php echo __('Other', 'theme') ?></option>
	                        </select>
	                    </div>
	                </div>
	            </div>
	        </div>
	    <?php
	}

	public function clg_render_property_data(){
	    ?>
	        <div class="casawp-lg_datawrapper">
	            <div class="casawp-lg_toggle">
	                <span class="casawp-lg_spanlabel"><?php echo __('Property type', 'theme') ?></span>
	                <div class="casawp-lg_togglebox">
	                    <input type="radio" class="casawp-lg_togglebox__switchinput" name="extra_data[Objektart]" value="Einfamilienhaus" id="casawplgHouse" checked>
	                    <label for="casawplgHouse" class="casawp-lg_togglebox__switchlabel casawp-lg_togglebox__switchlabel-off"><?php echo __('Single-family house', 'casawplg') ?></label>
	                    <input type="radio" class="casawp-lg_togglebox__switchinput" name="extra_data[Objektart]" value="Eigentumswohnung" id="casawplgApartment">
	                    <label for="casawplgApartment" class="casawp-lg_togglebox__switchlabel casawp-lg_togglebox__switchlabel-on"><?php echo __('Condominium', 'casawplg') ?></label>
	                    <span class="casawp-lg_togglebox__switchselection"></span>
	                </div>
	            </div>
	            <div class="casawp-lg_range">
	                <span><?php echo __('Net living area', 'casawplg') ?> (m<sup>2</sup>)</span>
	                <input type="range" min="10" max="1000" step="10" value="300" name="extra_data[Nettowohnfläche]" data-rangeslider>
	                <div class="clearfix"></div>
	            </div>
	            <div class="casawp-lg_range">
	                <span><?php echo __('Number of rooms', 'casawplg') ?></span>
	                <input type="range" min="1" max="10" step="0.5" name="extra_data[Anzahl Zimmer]" value="3" data-rangeslider>
	                <div class="clearfix"></div>
	            </div>
	            <div class="casawp-lg_range">
	                <span><?php echo __('Number of bathrooms', 'casawplg') ?></span>
	                <input type="range" min="1" max="10" step="1" value="2" name="extra_data[Anzahl Badezimmer]" data-rangeslider>
	                <div class="clearfix"></div>
	            </div>
	            <div class="casawp-lg_range">
	                <span><?php echo __('Building year', 'casawplg') ?></span>
	                <input type="range" min="<?php echo date("Y") - 100; ?>" max="<?php echo date("Y"); ?>" step="1" value="<?php echo date("Y") - 20; ?>" name="extra_data[Baujahr]" data-rangeslider>
	                <div class="clearfix"></div>
	            </div>
	        </div>
	    <?php
	}

	public function clg_render_map(){
	    ?>
	        <div class="casawp-lg_mapwrapper">
	            <div class="casawp-lg_searchboxwrapper" id="pac-card">
	                <h3><?php echo __('Where is the property located?', 'theme') ?></h3>
	                <div class="casawp-lg_searchboxinput">
	                    <input id="pac-input" required class="controls" type="text" placeholder="Adresse, Ort, PLZ">
	                </div>
	            </div>
	            <div id="casawp-lg_map"></div>
	            <input required type="hidden" id="cityName" name="extra_data[Ort]">
	            <input required type="hidden" id="cityLat" name="extra_data[Lat]">
	            <input required type="hidden" id="cityLng" name="extra_data[Lng]">
	        </div>
	    <?php
	}

	public function clg_render_primary_start_button($data){
	    ?>
	        <div class="casawp-lg_buttons center_buttons">
	            <a href="#" class="btn btn-primary btn-forward">
	                <?php echo $data ?>
	            </a>
	        </div>
	    <?php
	}

	public function clg_render_primary_back_button($data){
	    ?>
	        <a href="#" class="btn btn-primary btn-backward">
	            <?php echo $data ?>
	        </a>
	    <?php
	}

	public function clg_render_primary_forward_button($data){
	    ?>
	        <a href="#" class="btn btn-primary btn-forward">
	            <?php echo $data ?>
	        </a>
	    <?php
	}

	public function clg_render_primary_submit_button($data){
	    ?>
	        <button class="btn btn-primary" type="submit">
	            <?php echo $data ?>
	        </button>
	    <?php
	}

	public function clg_render_counter(){
	    ?>
	        <div class="casawp-lg_counter">
	            <div>
	                <span class="casawp-lg_number bg-primary">
	                    1
	                </span>
	            </div>
	            <div>
	                <span class="casawp-lg_number">
	                    2
	                </span>
	            </div>
	            <div>
	                <span class="casawp-lg_number">
	                    3
	                </span>
	            </div>
	            <div>
	                <span class="casawp-lg_number">
	                    4
	                </span>
	            </div>
	        </div>
	    <?php
	}

	public function clg_render_contentpart_one(){
		ob_start();
	    ?>
	        <h2>Kostenlose Marktpreiseinschätzung Ihrer Immobilie</h2>
	        <p>Die Bewertung Ihrer Immobilie ist kostenlos und dauert nur einige Minuten.</p>
	    <?php
	    return ob_get_contents();
	}

	public function clg_render_contentpart_two(){
	    ?>
	        <h2>
	            <svg width="20px" height="24px" viewBox="0 0 20 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
	                    <g class="strokeColor" transform="translate(-605.000000, -521.000000)" stroke="#ffffff">
	                        <g transform="translate(600.000000, 518.000000)">
	                            <g transform="translate(6.000000, 4.000000)">
	                                <path d="M17.5263158,9.47368421 C17.5263158,16.1052632 9,22.2631579 9,22.2631579 C9,22.2631579 0.473684211,16.1052632 0.473684211,9.47368421 C0.473684211,4.50378947 4.02915789,0.473684211 9,0.473684211 C13.9698947,0.473684211 17.5263158,4.50378947 17.5263158,9.47368421 L17.5263158,9.47368421 Z"></path>
	                                <polyline points="6.15789474 8.05263158 6.15789474 12.7894737 11.8421053 12.7894737 11.8421053 8.05263158"></polyline>
	                                <polygon points="4.26315789 8.05263158 9 3.78947368 13.7368421 8.05263158"></polygon>
	                                <polygon points="8.05263158 12.7894737 9.94736842 12.7894737 9.94736842 9.94736842 8.05263158 9.94736842"></polygon>
	                            </g>
	                        </g>
	                    </g>
	                </g>
	            </svg> Informationen zum Standort.
	        </h2>
	    <?php
	}


	public function clg_render_contentpart_three(){
	    ?>
	        <h2>
	            <svg width="20px" height="18px" viewBox="0 0 20 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linejoin="round">
	                    <g class="strokeColor" transform="translate(-675.000000, -524.000000)" stroke="#ffffff">
	                        <g transform="translate(670.000000, 518.000000)">
	                            <g transform="translate(6.000000, 6.000000)">
	                                <polyline stroke-linecap="round" points="2.625 9.375 2.625 16.875 15.375 16.875 15.375 9.75"></polyline>
	                                <polyline stroke-linecap="round" points="0.375 9 9 0.375 17.625 9"></polyline>
	                                <polyline stroke-linecap="round" points="12 1.125 14.625 1.125 14.625 3.75"></polyline>
	                                <path d="M12.75,9.832425 C12.75,11.789925 9.585,14.144925 9.2175,14.407425 C9.1575,14.459925 9.075,14.482425 9,14.482425 C8.925,14.482425 8.8425,14.459925 8.7825,14.407425 C8.415,14.144925 5.25,11.789925 5.25,9.832425 C5.25,8.437425 6.2925,7.597425 7.2975,7.597425 C7.875,7.597425 8.55,7.882425 9,8.624925 C9.45,7.882425 10.125,7.597425 10.7025,7.597425 C11.7075,7.597425 12.75,8.437425 12.75,9.832425 L12.75,9.832425 Z"></path>
	                            </g>
	                        </g>
	                    </g>
	                </g>
	            </svg> Informationen zu Ihrer Immobilie.
	        </h2>
	    <?php
	}

	public function clg_render_contentpart_four(){
	    ?>
	        <h2>
	            <svg width="20px" height="20px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linejoin="round">
	                    <g class="strokeColor" transform="translate(-745.000000, -522.000000)" stroke="#ffffff">
	                        <g transform="translate(740.000000, 518.000000)">
	                            <g transform="translate(6.000000, 5.000000)">
	                                <path d="M6.75,10.07622 L6.75,12.59982 L2.2419,14.20992 C1.1673,14.59422 0.45,15.61212 0.45,16.75242 L0.45,18.44982 L17.55,18.44982 L17.55,16.75242 C17.55,15.61212 16.8327,14.59422 15.7581,14.20992 L11.25,12.59982 L11.25,10.07622"></path>
	                                <path d="M13.5,5.4 C13.5,8.3817 11.4849,10.8 9,10.8 C6.5142,10.8 4.5,8.3817 4.5,5.4 C4.5,2.4183 6.5142,0 9,0 C11.4849,0 13.5,2.4183 13.5,5.4 L13.5,5.4 Z"></path>
	                                <path d="M13.45779,4.90779 C13.30659,4.92669 13.20219,4.92039 13.05009,4.95009 C11.51739,5.24529 10.53279,4.68999 9.68859,3.21309 C9.18279,4.18329 7.59969,4.95009 6.30009,4.95009 C5.66019,4.95009 5.10939,4.81869 4.55769,4.53069"></path>
	                            </g>
	                        </g>
	                    </g>
	                </g>
	            </svg> Informationen zu Ihrer Person.
	        </h2>
	    <?php
	}


	private $formLoaded = false;
	public function isFormLoaded(){
		return $this->formLoaded;
	}
	public function setFormLoaded(){
		$this->formLoaded = true;
	}


	private function storeInquiry($args, $formData){
		$inq_post_id = wp_insert_post( $args );
		if ($inq_post_id) {
			foreach ($formData as $key => $value) {
				add_post_meta( $inq_post_id, '_casawplg_inquiry_'.$key, $value , true);
			}
		}
		return get_post($inq_post_id);
	}

	public function renderForm($args){

		$template = $this->get_template();
		
		$formData =  $this->getFormData();
	//	die(print_r($formData));

		$msg = '';
		$state = '';
		$messages = array();
		if ($formData['post']) {
			if ($this->formValid()) {
				if (wp_verify_nonce( $_REQUEST['_wpnonce'], 'send-inquiry')) {
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


	public function getFormData($empty = false){
		
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
	public function addFieldValidationMessage($col, $message){
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
	public function setFieldRequired($col){
		$this->requiredFields[] = $col;
	}

	public function getFormMessages(){
		
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
						$valid = filter_var( $value, FILTER_VALIDATE_EMAIL );
						if (!$valid) {
							$messages[$col] = $defaults[$col];
						}
						break;
					case 'post':
						if (!$value) {
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

	public function formValid(){
		if (count($this->getFormMessages())) {
			return false;
		}
		return true;
	}


	public function sendCasamail($provider = false, $publisher = false, $inquiry, $formData){
		if (!$provider) {
			$provider = $this->get_option("provider_slug");
		}
		if (!$publisher) {
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

}



// Subscribe to the drop-in to the initialization event
add_action( 'casawplg_init', array( 'casasoft\casawplg\render', 'init' ) );
